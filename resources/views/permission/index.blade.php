@extends('base')

@section('title', 'Seznam uzivatelov')
@section('description', 'Výpis všech uzivatelov v administraci.')

@section('content')
    <table class="table table-striped table-bordered table-responsive-md">
        <thead>
        <tr>
            <th>Nazov</th>
            <th>Popis</th>
            <th>Controller</th>
            <th>Method</th>
            <th>Datum vytvoření</th>
            <th>Datum poslední změny</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse ($permissions as $permission)
            <tr>
                <td>
                    <a href="{{ route('permission.show', ['permission' => $permission]) }}">
                        {{ $permission->name }}
                    </a>
                </td>
                <td>{{ $permission->description }}</td>
                <td>{{ $permission->controller }}</td>
                <td>{{ $permission->method }}</td>
                <td>{{ $permission->created_at->isoFormat('LLL') }}</td>
                <td>{{ $permission->updated_at->isoFormat('LLL') }}</td>
                <td>
                    <a href="{{ route('permission.edit', ['permission' => $permission]) }}">Editovat</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">
                    Ziadny permission
                </td>
            </tr>
        @endforelse
        @if($permissions->hasPages())
            <tr>
                <td align="center" colspan="7">{{ $permissions->links() }}</td>
            </tr>
        @endif
        </tbody>

    </table>
    <a href="{{ route('permission.generate') }}" class="btn btn-primary">
        Vygeneruj permissions
    </a>
@endsection
