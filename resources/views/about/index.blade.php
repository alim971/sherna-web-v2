@extends('base')

@section('title', $page->title)
@section('description', 'Stranka s informaciami o nas a o nasich projektoch')

@section('content')
    <h1>{{$page->title}}</h1>
    <p>{{$page->content}}</p>
@endsection
