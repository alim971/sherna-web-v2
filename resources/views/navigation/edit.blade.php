@extends('base')

@section('title', 'Editace miestnosti ' . $page->name)
@section('description', 'Editor pro editaci miestnosti.')

@section('content')
    <h1>Editace navigacie  {{ $page->name }}</h1>

    <form action="{{ route('navigation.update', ['navigation' => $page->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <div class="form-group">
                <label for="order">Order</label>
                <input type="text" name="order" id="order" class="form-control" value="{{$page->order ?: old('order') }}" required minlength="3" maxlength="10"/>
            </div>
            <div class="form-group">
                <label for="public">Is public</label>
                <input type="checkbox" name="public" id="public" class="form-control" {{($page->public || !empty(old('public'))) ? "checked" : "" }} />
            </div>
            <div class="form-group">
                <label for="dropdown">Is dropdown</label>
                <input type="checkbox" name="dropdown" id="dropdown" onclick="myFunction()" class="form-control" {{(( session()->get( 'is_dropdown', false ) || $page->dropdown) || !empty(old('dropdown'))) ? "checked" : "" }} />
            </div>
            @include('modal.modal-form', ['title' => 'Podstranka'])
            <ul class="nav nav-tabs" style="margin-bottom: 3%">
                @foreach(\App\Language::all() as $language)
                    <li class="{{($language->id==$page->language->id ? "active":"")}}">
                        <a href="#{{$language->id}}" data-toggle="tab">{{$language->name}}</a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach(\App\Language::all() as $language)
                    @php
                    $nav = \App\Nav\Page::where('id', $page->id)->ofLang($language)->first();
                    @endphp
                    <div class="tab-pane fade {{($language->id==$page->language->id ? "active":"")}} in" id="{{$language->id}}">
                        <div class="form-group">
                            <label for="name">Meno</label>
                            <input type="text" name="name-{{$language->id}}" id="name-{{$language->id}}" class="form-control" value="{{$nav->name ?: old('name-' . $language->id) }}" required minlength="3" maxlength="80" />
                        </div>

                        <div class="not_dropdown {{$page->dropdown ? "d-none" : ""}}" >
                            <div class="form-group">
                                <input type="hidden" name="title-{{$language->id}}" id="title-{{$language->id}}" class="form-control" value="{{$page->url ?: old('title-' . $language->id) }}" required minlength="3" maxlength="80" />
                            </div>

                            <div class="form-group">
                                <label for="content">Obsah článku</label>
                            <textarea name="content-{{$language->id}}" id="content-{{$language->id}}" class="form-control editor" rows="8">
                                {{($page->text ? $page->text()->ofLang($language)->first()->content : old('content-' . $language->id)) }}
                            </textarea>
                            </div>
                        </div>

                        <div class="is_dropdown form-group {{!$page->dropdown ? "d-none" : ""}}">
                            @include('navigation.partials.subpages.index', [
                                            'subpages' => \Session::get('subpages-' . $language->id),
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
    @include('client.blog.partials.tinymce_partial')
    @include('navigation.partials.scripts.dropdown')
    @include('navigation.partials.scripts.delete')
@endpush
