@extends('base')

@section('title', $page->title)
@section('description', 'Stranka s informaciami o nas a o nasich projektoch')

@section('content')
    <main>
        <h1>{{$page->title}}</h1>
        <article class="article">{!!$page->content !!}</article>
    </main>
@endsection
