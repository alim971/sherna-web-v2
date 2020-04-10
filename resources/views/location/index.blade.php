@extends('base')

@section('title', 'Seznam miestnosti')
@section('description', 'Výpis všech miestnosti v administraci.')

@section('content')
    <table class="table table-striped table-bordered table-responsive-md">
        <thead>
        <tr>
            <th>Name</th>
            <th>Status</th>
            <th>Datum vytvoření</th>
            <th>Datum poslední změny</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse ($locations as $location)
            <tr>
                <td>
                    <a href="{{ route('location.show', ['location' => $location->id]) }}">
                        {{ $location->name }}
                    </a>
                </td>
                <td>{{ $location->status->status }}</td>
                <td>{{ $location->created_at->isoFormat('LLL') }}</td>
                <td>{{ $location->updated_at->isoFormat('LLL') }}</td>
                <td>
                    <a href="{{ route('location.edit', ['location' => $location->id]) }}">Editovat</a>
                    <a href="#" onclick="event.preventDefault(); $('#location-delete-{{ $location->url }}').submit();">Odstranit</a>

                    <form action="{{ route('location.destroy', ['location' => $location->id]) }}" method="POST" id="location-delete-{{ $location->url }}" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">
                    Nikdo zatím nevytvořil ziadnu miestnost.
                </td>
            </tr>
        @endforelse
        @if($locations->hasPages())
            <tr>
                <td align="center" colspan="5">{{ $locations->links() }}</td>
            </tr>
        @endif
        </tbody>
    </table>

    <a href="{{ route('location.create') }}" class="btn btn-primary">
        Vytvořit novu miestnost
    </a>
@endsection
