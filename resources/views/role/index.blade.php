@extends('base')

@section('title', 'Seznam uzivatelov')
@section('description', 'Výpis všech uzivatelov v administraci.')

@section('content')
    <table class="table table-striped table-bordered table-responsive-md">
        <thead>
        <tr>
            <th>Nazov</th>
            <th>Popis</th>
            <th>Datum vytvoření</th>
            <th>Datum poslední změny</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse ($roles as $role)
            <tr>
                <td>
                    <a href="{{ route('role.show', ['role' => $role]) }}">
                        {{ $role->name }}
                    </a>
                </td>
                <td>{{ $role->description }}</td>
                <td>{{ $role->created_at->isoFormat('LLL') }}</td>
                <td>{{ $role->updated_at->isoFormat('LLL') }}</td>
                <td>
                    <a href="{{ route('role.edit', ['role' => $role]) }}">Editovat</a>
                    <a href="#" onclick="event.preventDefault(); $('#role-delete-{{ $role->id }}').submit();">Odstranit</a>

                    <form action="{{ route('role.destroy', ['role' => $role]) }}" method="POST" id="role-delete-{{ $role->id }}" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">
                    Ziadny role
                </td>
            </tr>
        @endforelse
        @if($roles->hasPages())
            <tr>
                <td align="center" colspan="5">{{ $roles->links() }}</td>
            </tr>
        @endif
        </tbody>
    </table>
    <a href="{{ route('role.create') }}" class="btn btn-primary">
        Vytvořit novu rolu
    </a>
@endsection
