<!-- _comment_replies.blade.php -->

@foreach($comments as $comment)
    <div @if($depth < $comment->limit) class="display-comment" @endif>
        <strong>{{ $comment->user->name }}</strong>
        <p>{{ $comment->body }}</p>
        <a href="" id="reply"></a>
        @include('article.partials.comments.reply_partial', ['comment' => $comment, 'article_id' => $article_id])
        @include('article.partials.comments.nested_comment_partial', ['comments' => $comment->replies,
                 'article_id' => $article_id, 'depth' => $depth + 1])
    </div>
@endforeach
