@extends('base')

@section('title', $article->title)
@section('description', $article->description)

@section('content')
    <article class="article">
        <header>
            <h1 class="display-4 mb-0">{{ $article->title }}</h1>
        </header>

        <div class="article-content">{!! $article->content !!}</div>

        <footer>
            <p class="small text-secondary border-top pt-2 mt-4"><i class="fa fa-calendar"></i>
                {{ $article->updated_at->isoFormat('LLL') }}
            </p>
        </footer>
        <form method="post" action="{{ route('comment.store') }}">
            @csrf
            <div class="form-group">
                <input type="text" name="comment_body" class="form-control" />
                <input type="hidden" name="article_url" value="{{ $article->url }}" />
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-warning" value="Add Comment" />
            </div>
        </form>
    </article>
@endsection
