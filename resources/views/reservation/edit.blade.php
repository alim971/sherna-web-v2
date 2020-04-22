@extends('base')

@section('title', 'Editace miestnosti ' . $reservation->name)
@section('description', 'Editor pro editaci miestnosti.')

@section('content')
    <h1>Editace miestnosti {{ $reservation->name }}</h1>

    <form action="{{ route('reservation.update', ['reservation' => $reservation->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <ul class="nav nav-tabs" style="margin-bottom: 3%">
                @foreach(\App\Language::all() as $language)
                    <li class="{{($language->id==$reservation->language->id ? "active":"")}}">
                        <a href="#{{$language->id}}" data-toggle="tab">{{$language->name}}</a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach(\App\Language::all() as $language)
                    @php
                    $loc = \App\reservation::where('id', $reservation->id)->ofLang($language)->first();
                    @endphp
                    <div class="tab-pane fade {{($language->id==$reservation->language->id ? "active":"")}} in" id="{{$language->id}}">
                        <div class="form-group">
                            <label for="name">Meno</label>
                            <input type="text" name="name-{{$language->id}}" id="name-{{$language->id}}" class="form-control" value="{{$loc->name ?: old('name-' . $language->id) }}" required minlength="3" maxlength="80" />
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status">
                    @foreach(\App\reservationStatus::all() as $status)
                        <option value="{{$status->id}}" {{ $status->id == $reservation->status->id ? 'selected' : ''}}>
                            {{$status->name}}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Uložit miestnost</button>
        </div>
    </form>

@endsection
