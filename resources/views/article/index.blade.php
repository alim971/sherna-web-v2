@extends('base')

@section('title', 'Seznam článků')
@section('description', 'Výpis všech článků v administraci.')

@section('content')
    <table class="table table-striped table-bordered table-responsive-md">
        <thead>
        <tr>
            <th>Titulek</th>
            <th>Popisek</th>
            <th>Datum vytvssoření</th>
            <th>Datum poslední změny</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse ($articles as $article)
            <tr>
                <td>
                    <a href="{{ route('article.show', ['article' => $article->url]) }}">
                        {{ $article->url }}
                    </a>
                </td>
                <td>{{ $article->description }}</td>
                <td>{{ $article->created_at->isoFormat('LLL') }}</td>
                <td>{{ $article->updated_at->isoFormat('LLL') }}</td>
                <td>
                    <a href="{{ route('article.edit', ['article' => $article->url]) }}">Editovat</a>
                    <a href="#" onclick="event.preventDefault(); $('#article-delete-{{ $article->url }}').submit();">Odstranit</a>

                    <form action="{{ route('article.destroy', ['article' => $article->url]) }}" method="POST" id="article-delete-{{ $article->url }}" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">
                    Nikdo zatím nevytvořil žádný článek.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <a href="{{ route('article.create') }}" class="btn btn-primary">
        Vytvořit nový článek
    </a>
@endsection
