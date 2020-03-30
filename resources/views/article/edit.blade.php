@extends('base')

@section('title', 'Editace článku ' . $article->texts()->first()->title)
@section('description', 'Editor pro editaci článků.')

@section('content')
    <h1>Editace článku {{ $article->texts()->first()->title }}</h1>

    <form action="{{ route('article.update', ['article' => $article]) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <ul class="nav nav-tabs" style="margin-bottom: 3%">
                @foreach($texts as $text)
                    <li class="{{($text->language->id==1 ? "active":"")}}">
                        <a href="#{{$text->language->id}}" data-toggle="tab">{{$text->language->name}}</a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach($texts as $text)
                    <div class="tab-pane fade {{($text->language->id==1 ? "active":"")}} in" id="{{$text->language->id}}">
                        <div class="form-group">
                            <label for="title">Nadpis</label>
                            <input type="text" name="title-{{$text->language->id}}" id="title-{{$text->language->id}}" class="form-control" value="{{$text->title ?: old('title-' . $text->language->id) }}" required minlength="3" maxlength="80" />
                        </div>

                        <div class="form-group">
                            <label for="description">Popisek článku</label>
                            <textarea name="description-{{$text->language->id}}" id="description-{{$text->language->id}}" rows="4" class="form-control" required minlength="25" maxlength="255">{{$text->description ?: old('description-'. $text->language->id) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="content">Obsah článku</label>
                            <textarea name="content-{{$text->language->id}}" id="content-{{$text->language->id}}" class="form-control editor" rows="8">{{$text->content ?: old('content-' . $text->language->id) }}</textarea>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary">Uložit článek</button>
        </div>
    </form>

@endsection

@push('scripts')
    @include('article.partials.tinymce_partial')
@endpush
