<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Message as MessageData;
use Livewire\WithPagination;

class Message extends Component
{
    use WithPagination;

    public function render()
    {
        $messages = MessageData::get();

        return view('livewire.message', [
            'messages' => $messages->reverse()->paginate(6)
        ]);
    }
}