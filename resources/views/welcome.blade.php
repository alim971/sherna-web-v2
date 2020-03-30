@extends('base')

@section('title', 'Jednoduchý redakční systém v Laravel')
@section('description', 'Ukázkový tutoriál pro jednoduchý redakční systém v Laravel frameworku z programátorské sociální sítě itnetwork.cz')

@section('content')
    <h1 class="text-center mb-4">Jednoduchý redakční systém v Laravel</h1>

    @forelse ($articles as $article)
        <article class="article mb-5">
            <header>
                <h2>
                    <a href="{{ route('article.show', ['article' => $article]) }}">{{ $article->title }}</a>
                </h2>
            </header>

            <p class="article-content mb-1">{{ $article->description }}</p>


        </article>
    @empty
        <p>Zatím se zde nenachází žádné články.</p>
    @endforelse
@endsection
