@extends('base')

@section('title', 'Seznam miestnosti')
@section('description', 'Výpis všech miestnosti v administraci.')

@section('content')
    <table class="table table-striped table-bordered table-responsive-md">
        <thead>
        <tr>
            <th>Status</th>
            <th>Datum vytvoření</th>
            <th>Datum poslední změny</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse ($statuses as $status)
            <tr>
                <td>
                    <a href="{{ route('status.show', ['status' => $status->id]) }}">
                        {{ $status->name }}
                    </a>
                </td>
                <td>{{ $status->created_at->isoFormat('LLL') }}</td>
                <td>{{ $status->updated_at->isoFormat('LLL') }}</td>
                <td>
                    <a href="{{ route('status.edit', ['status' => $status->id]) }}">Editovat</a>
                    <a href="#" onclick="event.preventDefault(); $('#status-delete-{{ $status->url }}').submit();">Odstranit</a>

                    <form action="{{ route('status.destroy', ['status' => $status->id]) }}" method="POST" id="status-delete-{{ $status->url }}" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">
                    Nikdo zatím nevytvořil ziadny status.
                </td>
            </tr>
        @endforelse
        @if($statuses->hasPages())
            <tr>
                <td align="center" colspan="5">{{ $statuses->links() }}</td>
            </tr>
        @endif
        </tbody>
    </table>

    <a href="{{ route('status.create') }}" class="btn btn-primary">
        Vytvořit novy status
    </a>
@endsection
