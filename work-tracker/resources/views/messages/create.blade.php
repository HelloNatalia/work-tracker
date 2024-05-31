@extends('layouts.app')

@section('content')
<div>
    <h1>Nowa wiadomość</h1>
    <form action="{{ route('messages.store') }}" method="POST">
        @csrf
        <div>
            <input type="hidden" name="subject" value="{{ $subject }}">
            Temat: {{ $subject }}
        </div>
        <div>
        @if ($receiver_id === null)
            @if (Auth::user()->role == 2 || Auth::user()->role == 3)
                <label for="id_user_receiver">Odbiorca:</label>
                <select id="id_user_receiver" name="id_user_receiver" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                    @endforeach
                </select>
            @else
                <label for="id_user_receiver">Odbiorca:</label>
                <select id="id_user_receiver" name="id_user_receiver" required>
                    @foreach($admins as $admin)
                        <option value="{{ $admin->id }}">{{ $admin->first_name }} {{ $admin->last_name }}</option>
                    @endforeach
                </select>
            @endif
        @else
            <input type="hidden" name="id_user_receiver" value="{{ $receiver_id }}">
            Odbiorca: {{ $receiver_name }}
        @endif
        </div>
        <div>
            <label for="text">Treść:</label>
            <textarea id="text" name="text" required></textarea>
        </div>
        <button type="submit">Wyślij</button>
    </form>
</div>
@endsection