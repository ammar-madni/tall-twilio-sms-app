<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function smsStatusCallback(Request $request, $id)
    {
        $status = $request->status;

        $message = Message::whereId($id)->first();
        $message->status = $status;
        $message->save();
    }
}
