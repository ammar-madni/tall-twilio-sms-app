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
                    /*
                    Twilio throws an exception if the route provided is not a valid url
                    so I have tested my api endpoint locally using Postman with the same
                    payload provided here:
                    https://www.twilio.com/docs/usage/webhooks/sms-webhooks
                    */

                    // TODO: figure out why exception is not thrown when message is sent via job but is thrown when sent directly from components submit function?
                    'statusCallback' => route('sms-status-callback', ['id' => $message->id]),
                ]
            );
        }, function () {
            return $this->release(5);
        });
    }

    public function failed(Exception $exception)
    {
        // TODO: handle exception
    }
}
