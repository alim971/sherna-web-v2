@extends('base')

@section('title', $page->name)
@section('description', $page->name)

@section('content')
    <main>
        <h1>{{ $page->name }}</h1>
        <div>
            <p>Status: {{ $page->status->status }}</p>
        </div>
    </main>
@endsection
