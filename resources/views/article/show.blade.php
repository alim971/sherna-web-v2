@extends('base')

@section('title', $article->text->title)
@section('description', $article->text->description)

<style>
    .display-comment .display-comment {
        margin-left: 40px
    }
</style>

@section('content')
    <main>
        <article class="article">
            <header>
                <h1 class="display-4 mb-0">{{ $article->text->title }}</h1>
            </header>

            <div class="article-content">{!! $article->text->content !!}</div>

            <footer>
                <p class="small text-secondary border-top pt-2 mt-4"><i class="fa fa-calendar"></i>
                    {{ $article->text->updated_at->isoFormat('LLL') }}
                </p>
            </footer>
        </article>
        <div>
            <h4>Komentare</h4>
            @forelse($article->comments as $comment)
            <div class="display-comment">
                <strong>{{ $comment->user->name }}</strong>
                <p>{{ $comment->body }}</p>
                @include('article.partials.comments.reply_partial', ['comment' => $comment, 'article_id' => $article->id])
                @include('article.partials.comments.nested_comment_partial', ['comments' => $comment->replies,
                 'article_id' => $article->id, 'depth' => 1])
            </div>
            @empty
                @auth
                    <div class="text-center">
                        <h4>Nikdo zatím nenapisal komentar. Bud prvy!</h4>
                    </div>
                @endauth
            @endforelse
            @auth
                <form method="post" action="{{ route('comment.store', ['article' => $article]) }}">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="comment_body" class="form-control" />
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-warning" value="Add Comment" />
                    </div>
                </form>
            @else
                <div class="text-center">
                    <h4>Aby si mohol pridavat komentare, musis sa prihlasit!</h4>
                </div>
            @endauth
        </div>
    </main>
@endsection
