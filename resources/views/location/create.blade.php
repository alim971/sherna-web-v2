@extends('base')

@section('title', 'Tvorba článku')
@section('description', 'Editor pro vytvoření nového článku.')

@section('content')
    <h1>Tvorba článku</h1>

    <form action="{{ route('location.store') }}" method="POST">
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
                            <label for="name">Meno</label>
                            <input type="text" name="name-{{$language->id}}" id="name-{{$language->id}}" class="form-control" value="{{ old('name-' . $language->id) }}" required minlength="3" maxlength="80" />
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status">
                    @foreach(\App\LocationStatus::all() as $status)
                        <option value="{{$status->id}}">
                            {{$status->status}}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Uložit miestnost</button>
        </div>
    </form>

@endsection
