@extends('base')

@section('title', 'Tvorba statusu')
@section('description', 'Editor pro vytvoření nového statusu.')

@section('content')
    <h1>Tvorba statusu</h1>

    <form action="{{ route('status.store') }}" method="POST">
        @csrf
        <div>
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
                            <label for="status">Status</label>
                            <input type="text" name="status-{{$language->id}}" id="status-{{$language->id}}" class="form-control" value="{{ old('status-' . $language->id) }}" required minlength="3" maxlength="80" />
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary">Uložit miestnost</button>
        </div>
    </form>

@endsection
