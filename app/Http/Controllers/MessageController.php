<?php

namespace App\Http\Controllers;

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
        return view('messages.index');
    }

    public function create()
    {
        return view('messages.new-message');
    }
}
