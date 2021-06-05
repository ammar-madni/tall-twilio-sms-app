<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //comment this out to test via ngrok.
        $this->middleware('valid.request');
    }

    public function smsStatusCallback(Request $request, $id)
    {
        if ($request->AccountSid == getenv("TWILIO_ACCOUNT_SID")) {
            $status = $request->MessageStatus;
    
            $message = Message::whereId($id)->first();
            $message->status = $status;
            $message->save();
        } else {
            info('A request was made to: ' . url($request->path()) . ' - However, the request credentials did not match.');
        }
    }
}
