<!-- _comment_replies.blade.php -->

@foreach($comments as $comment)
    <div @if($depth < $comment->limit) class="display-comment" @endif>
        <div class="grid grid-pad">
            <div class="col-md-2 col-xs-2">
                <i class="fa fa-fw fa-users"></i>
                <img src="{{ $comment->user->image }}" class="" alt="">
            </div>
            <div class="col-md-10 col-xs-10 comment comment-radius">
                <strong>{{ $comment->user->name }}</strong>
                <p>{{ $comment->body }}</p>
            </div>
            <div class="text-right">{{ $comment->updated_at->diffForHumans() }}</div>
        </div>
        <a href="" id="reply"></a>
        @include('client.blog.partials.comments.reply_partial', ['comment' => $comment, 'article_id' => $article_id])
        @include('client.blog.partials.comments.nested_comment_partial', ['comments' => $comment->replies,
                 'article_id' => $article_id, 'depth' => $depth + 1])
    </div>
@endforeach
