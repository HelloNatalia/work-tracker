@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Wszystkie odebrane wiadomości</h2>
        <div class="row">
            <div class="col-md-12">
                @if ($received_messages->count() > 0) 
                    <ul>
                @foreach ($received_messages as $message)
                    <li>
                        <strong>Temat:</strong> {{ $message->subject }}<br>
                        <strong>Data wysłania:</strong> {{ $message->date_send }}<br>
                        <strong>Nadawca:</strong>
                        @if ($message->id_user_sender)
                            @php
                                $sender = \App\Models\User::find($message->id_user_sender);
                            @endphp
                        @if ($sender)
                            {{ $sender->first_name }} {{ $sender->last_name }}<br>
                        @endif
                        @endif
                        <strong>Status:</strong> {{ $message->status }}<br>
                        <button class="btn btn-link" data-toggle="collapse" data-target="#thread_{{ $message->id }}">Pokaż wątek</button>
                        <div id="thread_{{ $message->id }}" class="collapse">
                            <ul>
                            @php
                                $threadMessages = \App\Models\Message::where('id_thread', $message->id_thread)->get();
                            @endphp
                            @foreach ($threadMessages as $threadMessage)
                                <li>
                                    <strong>Data wysłania:</strong> {{ $threadMessage->date_send }}<br>
                                    <strong>Treść:</strong> {{ $threadMessage->text }}<br>
                                </li>
                            @endforeach
                            </ul>
                        </div>
                        <a href="{{ route('messages.create', ['receiver_id' => $message->id_user_sender,'subject' => $message->subject]) }}" class="btn btn-primary">Odpowiedz</a>
                    </li>
                @endforeach

                    </ul>
                @else
                    <p>Brak wysłanych wiadomości.</p>
                @endif
            </div>
        </div>
    </div>
@endsection