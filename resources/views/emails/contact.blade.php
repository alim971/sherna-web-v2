@component('mail::message')
    Ahoj,

    Právě ti přišla zpráva z kontaktního formuláře na webové stránce *{{ config('app.name') }}* (`{{ config('app.url') }}`).

    Obsah zprávy je následující:

    @component('mail::panel')
        {{ $message }}
    @endcomponent

    > Pokud chceš odepsat na tento email, stačí jednoduše odpovědět, jelikož odesílatelem je právě daný uživatel, co ti zprávu napsal.

    Díky za přečtení!<br>
    {{ config('app.name') }}
@endcomponent
