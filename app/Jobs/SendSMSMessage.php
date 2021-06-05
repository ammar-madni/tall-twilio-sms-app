<?php

namespace App\Jobs;

use App\Models\Message;
use Exception;
use Twilio\Rest\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;

class SendSMSMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;
    /**
     * The maximum number of unhandled exceptions to allow before failing.
     *
     * @var int
     */
    public $maxExceptions = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Determine the time at which the job should timeout.
     *
     * @return \DateTime
     */
    public function retryUntil()
    {
        return now()->addMinutes(10);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Redis::throttle('key')->block(0)->allow(1)->every(15)->then(function () {
            $message = $this->message;

            $account_sid = getenv("TWILIO_ACCOUNT_SID");
            $auth_token = getenv("TWILIO_AUTH_TOKEN");
            $client = new Client($account_sid, $auth_token);
               
            $client->messages->create(
                $message->phone,
                [
                    'from' => $message->user->twilio_phone, 
                    'body' => $message->body,
                    'statusCallback' => route('sms-status-callback', ['id' => $message->id]),

                    // When testing with ngrok this provides Twilio's webhook the ngrok url with the dynamic path to the correct endpoint.
                    // 'statusCallback' => 'https://your.ngrok.io' . route('sms-status-callback', ['id' => $message->id], false),
                ]
            );
        }, function () {
            return $this->release(5);
        });
    }

    public function failed(Exception $exception)
    {
        info('Max exceptions exceeded.' . $exception->getMessage());

        $status = 'failed';

        $message = $this->message;

        $message->status = $status;
        
        $message->save();
    }
}
