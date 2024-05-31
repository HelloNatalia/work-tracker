@extends('layouts.app')

@section('content')
<div>
    <h1>Wiadomości</h1>
    <ul>
        <li><a href="{{ route('messages.sentMessages') }}">Wysłane wiadomości</a></li>
        <li><a href="{{ route('messages.receivedMessages') }}">Odebrane wiadomości</a></li>
        <li><a href="{{ route('messages.create') }}">Nowa wiadomość</a></li>
    </ul>
</div>
@endsection