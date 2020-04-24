@auth
    <form method="post" action="{{ route('comment.reply', ['article' => $article]) }}">
        @csrf
        <div class="form-group">
            <textarea name="comment_body" required minlength="5" class="form-control comment-radius"></textarea>
            <input type="hidden" name="article_id" value="{{ $article_id }}" />
            <input type="hidden" name="comment_id" value="{{ $comment->id }}" />
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-warning" value="{{ trans('comment.reply') }}" />
        </div>
    </form>
@endauth
