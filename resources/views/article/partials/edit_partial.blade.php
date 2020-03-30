<form action="{{ isset($isPut) ? route('article.update', ['article' => $article]) : route('article.store') }}" method="POST">
    @csrf
    @if(isset($isPut))
        @method('PUT')
    @endif
    <div>
        <div class="form-group">
            <label for="url">URL</label>
            <input type="text" name="url" id="url" class="form-control" value="{{ $article->url ?:  old('url') }}" required minlength="3" maxlength="80" />
        </div>
        <ul class="nav nav-tabs" style="margin-bottom: 3%">
            @foreach(\App\Language::all() as $lang)
                <li class="{{($lang->id==1 ? "active":"")}}">
                    <a href="#{{$lang->id}}" data-toggle="tab">{{$lang->name}}</a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content">
            @foreach(\App\Language::all() as $lang)
                <div class="tab-pane fade {{($lang->id==1 ? "active":"")}} in" id="{{$lang->id}}">
                    <div class="form-group">
                        <label for="title">Nadpis</label>
                        <input type="text" name="title-{{$lang->id}}" id="title-{{$lang->id}}" class="form-control" value="{{$article->title ?: old('title-' . $lang->id) }}" required minlength="3" maxlength="80" />
                    </div>

                    <div class="form-group">
                        <label for="description">Popisek článku</label>
                        <textarea name="description-{{$lang->id}}" id="description-{{$lang->id}}" rows="4" class="form-control" required minlength="25" maxlength="255">{{$article->description ?: old('description-'. $lang->id) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="content">Obsah článku</label>
                        <textarea name="content-{{$lang->id}}" id="content-{{$lang->id}}" class="form-control editor" rows="8">{{$article->content ?: old('content-' . $lang->id) }}</textarea>
                    </div>
                </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary">{{$buttonText}}</button>
    </div>
</form>
