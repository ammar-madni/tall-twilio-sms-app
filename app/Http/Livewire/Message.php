<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Message as MessageData;

class Message extends Component
{
    public function render()
    {
        $messages = MessageData::get();

        return view('livewire.message', [
            'messages' => $messages
        ]);
    }
}