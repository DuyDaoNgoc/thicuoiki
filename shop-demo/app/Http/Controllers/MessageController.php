<?php
namespace App\Http\Controllers;

use App\Events\NewMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        // Lấy dữ liệu tin nhắn từ request
        $message = $request->input('message');

        // Phát sự kiện tới frontend qua Pusher
        event(new NewMessage($message));

        return response()->json(['status' => 'Message sent!']);
    }
}