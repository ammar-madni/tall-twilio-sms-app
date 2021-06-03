<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Twilio\Rest\Client;

class NewMessageForm extends Component
{
    public $phone;
    public $body;
    public $success;
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
        
        $message = auth()->user()->messages()->create([
            'user_id' => auth()->id(),
            'phone' => $this->phone,
            'body' => $this->body
        ]);

        $account_sid = getenv("TWILIO_ACCOUNT_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $client = new Client($account_sid, $auth_token);
            
        $client->messages->create(
            $message->phone,
            [
                'from' => $message->user->twilio_phone, 
                'body' => $message->body,
            ]
        );
        
        $this->reset(['phone', 'body']);
        $this->success = 'Message created successfully.';
    }
}
