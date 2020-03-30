@extends('base')

@section('title', 'Kontakt')
@section('description', 'Kontaktujte nás pomocí vestavěného formuláře.')

@section('content')
    <h1>Kontakt</h1>

    <form action="{{ route('contact.send') }}" method="POST">
        @csrf

        <div class="row">
            <div class="form-group col-md-8">
                <label for="email">Vaše emailová adresa</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required />
            </div>
            <div class="form-group col-md-4">
                <label for="year">Aktuální rok (antispam)</label>
                <input type="number" name="year" id="year" class="form-control" required />
            </div>
        </div>

        <div class="form-group">
            <label for="message">Zpráva</label>
            <textarea name="message" id="message" rows="10" class="form-control" required minlength="100">{{ old('message') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Odeslat</button>
    </form>
@endsection
