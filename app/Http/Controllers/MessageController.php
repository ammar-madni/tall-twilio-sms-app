<?php

namespace App\Http\Controllers;

use App\Models\Message;

class MessageController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $messages = Message::get();

        return view('messages.index', [
            'messages' => $messages->reverse()->paginate(6)
        ]);
    }

    public function create()
    {
        return view('messages.new-message');
    }
}
