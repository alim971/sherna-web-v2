@extends('base')

@section('title', $permission->name)
@section('description', $permission->description)

@section('content')
    <main>
        <h1>{{ $permission->name }}</h1>
        <div>
            <p>Description: {{ $permission->description }}</p>
        </div>
        <div>
            <p>Controller: {{ $permission->controller }}</p>
        </div>
        <div>
            <p>Method: {{ $permission->method }}</p>
        </div>
    </main>
@endsection
