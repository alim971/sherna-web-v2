@component('mail::message')
    Ahoj,

    Právě si vytvoril rezervaciu na webové stránce *{{ config('app.name') }}* (`{{ config('app.url') }}`), do miestnosti,
    ktora je na kluc. Pre potvrdenie platnosti rezervacia, a informacii o predani klucov pockaj na potvrdzujuci email.

    Detail rezervacie je následující:

    @component('mail::panel')
        Start     :  {{ $reservation->start_at->isoFormat('LLL') }}
        End       :  {{ $reservation->end_at->isoFormat('LLL') }}
        VR        :  {{ $reservation->vr ? "Ano" : "Nie" }}
        Location  :  {{ $reservation->location->name }}
    @endcomponent

{{--    > Pokud chceš odepsat na tento email, stačí jednoduše odpovědět, jelikož odesílatelem je právě daný uživatel, co ti zprávu napsal.--}}

    Díky za přečtení!<br>
    {{ config('app.name') }}
@endcomponent
