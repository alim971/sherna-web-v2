@extends('base')

@section('title', '{{title}}')
@section('description', 'Stranka s informaciami o nas a o nasich projektoch')

@section('content')
    <h1 class="text-center mb-4">{{}}</h1>

    @forelse ($articles as $article)
        <article class="article mb-5">
            <header>
                <h2>
                    <a href="{{ route('article.show', ['article' => $article]) }}">{{ $article->title }}</a>
                </h2>
            </header>

            <p class="article-content mb-1">{{ $article->description }}</p>

            <footer>
                <p class="small text-secondary">
                    <i class="fa fa-calendar"></i> Naposledy upraveno {{ $article->updated_at->diffForHumans() }}
                </p>
            </footer>
        </article>
    @empty
        <p>Zatím se zde nenachází žádné články.</p>
    @endforelse
@endsection
