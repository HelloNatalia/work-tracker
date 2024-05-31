<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class MessageController extends Controller
{
    public function index()
    {

        return view('messages.index');
    }
    public function create($receiver_id = null, $subject = null)
{
    $users = User::all(); // Pobieramy wszystkich użytkowników oprócz administratorów
    $admins = User::whereIn('role', [2, 3])->get(); // Pobieramy wszystkich administratorów
    return view('messages.create', ['admins' => $admins, 'users' => $users, 'receiver_id' => $receiver_id, 'subject' => $subject]);
}
    // Utworzenie nowej wiadomości
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'id_user_receiver' => 'required|exists:users,id',
            'text' => 'required'
        ]);
        $senderId = Auth::id();
        $receiverId = $request->id_user_receiver;
        $message = new Message();
        $message->subject = $request->subject;
        $message->id_thread = md5($senderId . '_' . $receiverId . '_' . $request->input('subject'));
        $message->id_user_sender = $senderId;
        $message->id_user_receiver = $receiverId;
        $message->text = $request->text;
        $message->date_send = now();
        $message->status = 'sent';
        $message->save();

        return response()->json(['message' => 'Message sent successfully'], 200);
    }

    // Lista wysłanych wiadomości
    public function sentMessages()
    {
        $user_id = Auth::id();
        $sent_messages = Message::where('id_user_sender', $user_id)->get();
        return view('messages.sentMessages', ['sent_messages' => $sent_messages]);
    }

    // Lista odebranych wiadomości
    public function receivedMessages()
    {
        $user_id = Auth::id();
        $received_messages = Message::where('id_user_receiver', $user_id)->get();
        return view('messages.receivedMessages', ['received_messages' => $received_messages]);
    }
}