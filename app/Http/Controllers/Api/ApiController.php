<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function smsStatusCallback(Request $request, $id)
    {
        if ($request->account_sid == getenv("TWILIO_ACCOUNT_SID")) {
            $status = $request->status;
    
            $message = Message::whereId($id)->first();
            $message->status = $status;
            $message->save();
        } else {
            info('A request was made to: ' . url($request->path()) . ' - However, the request credentials did not match.');
        }
    }
}
