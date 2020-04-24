@extends('base')

@section('title', 'Editace statusu ' . $status->name)
@section('description', 'Editor pro editaci statusu.')

@section('content')
    <h1>Editace statusu {{ $status->name }}</h1>

    <form action="{{ route('status.update', ['status' => $status->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <ul class="nav nav-tabs" style="margin-bottom: 3%">
                @foreach(\App\Language::all() as $language)
                    <li class="{{($language->id==$status->language->id ? "active":"")}}">
                        <a href="#{{$language->id}}" data-toggle="tab">{{$language->name}}</a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach(\App\Language::all() as $language)
                    @php
                    $loc = \App\LocationStatus::where('id', $status->id)->ofLang($language)->first();
                    @endphp
                    <div class="tab-pane fade {{($language->id==$status->language->id ? "active":"")}} in" id="{{$language->id}}">
                        <div class="form-group">
                            <label for="status">Meno</label>
                            <input type="text" name="status-{{$language->id}}" id="status-{{$language->id}}" class="form-control" value="{{$loc->status ?: old('status-' . $language->id) }}" required minlength="3" maxlength="80" />
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary">Uložit miestnost</button>
        </div>
    </form>

@endsection
