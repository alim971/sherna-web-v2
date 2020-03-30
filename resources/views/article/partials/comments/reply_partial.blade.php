@auth
    <form method="post" action="{{ route('comment.reply', ['article' => $article]) }}">
        @csrf
        <div class="form-group">
            <input type="text" name="comment_body" required minlength="5" class="form-control" />
            <input type="hidden" name="article_id" value="{{ $article_id }}" />
            <input type="hidden" name="comment_id" value="{{ $comment->id }}" />
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-warning" value="Reply" />
        </div>
    </form>
@endauth
