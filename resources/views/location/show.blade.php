@extends('base')

@section('title', $location->name)
@section('description', $location->name)

@section('content')
    <main>
        <h1>{{ $location->name }}</h1>
        <div>
            <p>Status: {{ $location->status->status }}</p>
        </div>
    </main>
@endsection
