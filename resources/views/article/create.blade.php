@extends('base')

@section('title', 'Tvorba článku')
@section('description', 'Editor pro vytvoření nového článku.')

@section('content')
    <h1>Tvorba článku</h1>

    <form action="{{ route('article.store') }}" method="POST">
        @csrf
        <div>
            <div class="form-group">
                <label for="url">URL</label>
                <input type="text" name="url" id="url" class="form-control" value="{{old('url') }}" required minlength="3" maxlength="80" />
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
                            <input type="text" name="title-{{$lang->id}}" id="title-{{$lang->id}}" class="form-control" value="{{old('title-' . $lang->id) }}" required minlength="3" maxlength="80" />
                        </div>

                        <div class="form-group">
                            <label for="description">Popisek článku</label>
                            <textarea name="description-{{$lang->id}}" id="description-{{$lang->id}}" rows="4" class="form-control" required minlength="25" maxlength="255">{{old('description-'. $lang->id) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="content">Obsah článku</label>
                            <textarea name="content-{{$lang->id}}" id="content-{{$lang->id}}" class="form-control editor" rows="8">{{old('content-' . $lang->id) }}</textarea>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary">Vytvořit článek</button>
        </div>
    </form>

@endsection

@push('scripts')
    @include('client.blog.partials.tinymce_partial')
@endpush
