@extends('base')

@section('title', 'Seznam rezervacii')
@section('description', 'Výpis všech rezervacii.')

@section('content')
    <table class="table table-striped table-bordered table-responsive-md">
        <thead>
        <tr>
            <th>User</th>
            <th>Location</th>
            <th>Start</th>
            <th>End</th>
            <th>Duration</th>
            <th>Vr</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse ($reservations as $reservation)
            <tr>
                <td>
                    {{ $reservation->user->name }}
                </td>
                <td>{{ $reservation->location->name }}</td>
                <td>{{ $reservation->start->isoFormat('LLL') }}</td>
                <td>{{ $reservation->end->isoFormat('LLL') }}</td>
                <td>{{ $reservation->duration() }}</td>
                <td>{{ $reservation->vr }}</td>
                <td>
                    <a href="#" class="click-modal" data-toggle="modal" data-target="#view-modal"
                       data-url="{{ route('reservation.edit', ['reservation' => $reservation]) }}">Editovat</a>
                    <a href="#" onclick="event.preventDefault(); $('#reservation-delete').submit();">Odstranit</a>

                    <form action="{{ route('reservation.destroy', ['reservation' => $reservation]) }}" method="POST" id="reservation-delete" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">
                    Nikdo zatím nevytvořil ziadnu rezervaciu.
                </td>
            </tr>
        @endforelse
        @if($reservations->hasPages())
            <tr>
                <td align="center" colspan="6">{{ $reservations->links() }}</td>
            </tr>
        @endif
        </tbody>
    </table>
    @include('modal.button-modal', [
    'route' => route('reservation.create'),
    'btnText' => 'Vytvor rezervaciu',
    ])
    @include('modal.modal-form', ['title' => 'Rezervacia'])
{{--    <a href="{{ route('reservation.create') }}" class="btn btn-primary">--}}
{{--        Vytvořit novu miestnost--}}
{{--    </a>--}}
@endsection
{{--@push('scripts')--}}
{{--    @include('reservation.scripts.datetimepicker')--}}
{{--@endpush--}}
