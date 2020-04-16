@extends('base')

@section('title', 'Seznam nastaveni')
@section('description', 'Výpis všech článků v administraci.')

@section('content')
    <div>
        <form action="{{ route('settings.update') }}" method="POST">
        @foreach ($settings as $setting)
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="value-{{$setting->id}}">{{$setting->name}}</label>
                    <input type="number" name="value-{{$setting->id}}" id="value-{{$setting->id}}" class="form-control" value="{{$setting->value ?: old('value-' .$setting->id) }}" required />
                </div>
        @endforeach
            <button type="submit" class="btn btn-primary">Uložit</button>
        </form>
    </div>
@endsection
