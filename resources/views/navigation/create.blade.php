@extends('base')

@section('title', 'Tvorba článku')
@section('description', 'Editor pro vytvoření nového článku.')

@section('content')
    <h1>Tvorba článku</h1>

    <form action="{{ route('navigation.store') }}" method="POST">
        @csrf
        <div>
            <div class="form-group">
                <label for="url">Url</label>
                <input type="text" name="url" id="url" class="form-control" value="{{old('url') }}" required minlength="3" maxlength="10"/>
            </div>
            <div class="form-group">
                <label for="order">Order</label>
                <input type="text" name="order" id="order" class="form-control" value="{{old('order') }}" />
            </div>
            <div class="form-group">
                <label for="public">Is public</label>
                <input type="checkbox" name="public" id="public" class="form-control" {{(!empty(old('public'))) ? "checked" : "" }} />
            </div>
            <div class="form-group">
                <label for="dropdown">Is dropdown</label>
                <input type="checkbox" name="dropdown" id="dropdown" onclick="myFunction()" class="form-control" {{(session()->get( 'is_dropdown', false ) || !empty(old('dropdown'))) ? "checked" : "" }} />
            </div>
            <ul class="nav nav-tabs" style="margin-bottom: 3%">
                @foreach(\App\Language::all() as $language)
                    <li class="{{($language->id==1 ? "active":"")}}">
                        <a href="#{{$language->id}}" data-toggle="tab">{{$language->name}}</a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach(\App\Language::all() as $language)
                    <div class="tab-pane fade {{($language->id==1 ? "active":"")}} in" id="{{$language->id}}">
                        <div class="form-group">
                            <label for="name">Meno</label>
                            <input type="text" name="name-{{$language->id}}" id="name-{{$language->id}}" class="form-control" value="{{old('name-' . $language->id) }}" required minlength="3" maxlength="80" />
                        </div>

                        <div class="not_dropdown {{(session()->get( 'is_dropdown', false ) || !empty(old('dropdown'))) ? "d-none" : ""}}" >
                            <div class="form-group">
                                <input type="hidden" name="title-{{$language->id}}" id="title-{{$language->id}}" class="form-control" value="{{old('title-' . $language->id) }}" required minlength="3" maxlength="80" />
                            </div>

                            <div class="form-group">
                                <label for="content">Obsah článku</label>
                                <textarea name="content-{{$language->id}}" id="content-{{$language->id}}" class="form-control editor" rows="8">
                                {{old('content-' . $language->id) }}
                            </textarea>
                            </div>
                        </div>

                        <div class="is_dropdown form-group {{ (!session()->get( 'is_dropdown', false ) || empty(old('dropdown'))) ? "d-none" : ""}}">
                            @include('navigation.partials.subpages.index', [
                                    'subpages' => \Session::get('subpages-' . $language->id,[]),
                                    'lang_id' => $language->id,
                                    ])
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary">Uložit miestnost</button>
        </div>
    </form>

@endsection

@push('scripts')
    @include('article.partials.tinymce_partial')
    @include('navigation.partials.scripts.script')
@endpush
