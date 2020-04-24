@extends('base')

@section('title', 'Editace článku ' . $article->text->title)
@section('description', 'Editor pro editaci článků.')

@section('content')
    <h1>Editace článku {{ $article->title }}</h1>

    <form action="{{ route('article.update', ['article' => $article]) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <ul class="nav nav-tabs" style="margin-bottom: 3%">
                @foreach(\App\Language::all() as $language)
                    <li class="{{($language->id==$article->text->language->id ? "active":"")}}">
                        <a href="#{{$language->id}}" data-toggle="tab">{{$language->name}}</a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach(\App\Language::all() as $language)
                    @php
                    $text = $article->text->ofLang($language)->first();
                    @endphp
                    <div class="tab-pane fade {{($language->id==$article->text->language->id ? "active":"")}} in" id="{{$language->id}}">
                        <div class="form-group">
                            <label for="title">Nadpis</label>
                            <input type="text" name="title-{{$language->id}}" id="title-{{$language->id}}" class="form-control" value="{{$text->title ?: old('title-' . $language->id) }}" required minlength="3" maxlength="80" />
                        </div>

                        <div class="form-group">
                            <label for="description">Popisek článku</label>
                            <textarea name="description-{{$language->id}}" id="description-{{$language->id}}" rows="4" class="form-control" required minlength="25" maxlength="255">{{$text->description ?: old('description-'. $language->id) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="content">Obsah článku</label>
                            <textarea name="content-{{$language->id}}" id="content-{{$language->id}}" class="form-control editor" rows="8">{{$text->content ?: old('content-' . $language->id) }}</textarea>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary">Uložit článek</button>
        </div>
    </form>

@endsection

@push('scripts')
    @include('client.blog.partials.tinymce_partial')
@endpush
