<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NewMessageForm extends Component
{
    public $phone;
    public $body;
    public $success;
    protected $rules = [
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
        
        auth()->user()->messages()->create([
            'user_id' => auth()->id(),
            'phone' => $this->phone,
            'body' => $this->body
        ]);

        // TODO: Queue SMS message to be sent via twilio api using a job.
        
        $this->reset(['phone', 'body']);
        $this->success = 'Message created successfully.';
    }
}
