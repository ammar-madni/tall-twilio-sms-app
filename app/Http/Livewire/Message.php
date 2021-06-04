<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Message extends Component
{
    public $message;
    public $statusFinalPossiblities = ['sent', 'delivered', 'failed', 'undelivered'];
    public $statusIsFinal = false;

    public function render()
    {
        if (in_array($this->message->status, $this->statusFinalPossiblities)) {
            $this->statusIsFinal = true;
        }

        return view('livewire.message');
    }
}