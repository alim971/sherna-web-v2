@extends('base')

@section('title', $reservation->name)
@section('description', $reservation->name)

@section('content')
    <main>
        <h1>{{ $reservation->name }}</h1>
        <div>
            <p>Status: {{ $reservation->status->status }}</p>
        </div>
    </main>
@endsection
