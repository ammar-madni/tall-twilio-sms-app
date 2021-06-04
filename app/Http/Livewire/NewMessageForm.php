<?php

namespace App\Http\Livewire;

use App\Jobs\SendSMSMessage;
use Livewire\Component;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class NewMessageForm extends Component
{
    use WithRateLimiting;

    public $phone;
    public $body;
    protected $rules = [
        // uk numbers only, switch to lookup api later.
        'phone' => ['required', 'regex:/^(\+44)(?:\d\s?){9,10}$/'], 
        'body' => 'required|max:140'
    ];

    public function render()
    {
        return view('livewire.new-message-form');
    }

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function submit()
    {
        $this->validate();

        try {
            $this->rateLimit(1, 15);

            $message = auth()->user()->messages()->create([
                'user_id' => auth()->id(),
                'phone' => $this->phone,
                'body' => $this->body
            ]);
    
            SendSMSMessage::dispatch($message);

            $this->reset(['phone', 'body']);
            session()->flash('success', 'Message created successfully.');

        } catch (TooManyRequestsException $exception) {
            session()->flash('error', "Slow down! Please wait another $exception->secondsUntilAvailable seconds to send another message.");
            
            return;
        }
    }
}
