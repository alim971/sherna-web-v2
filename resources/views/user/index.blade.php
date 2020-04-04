@extends('base')

@section('title', 'Seznam uzivatelov')
@section('description', 'Výpis všech uzivatelov v administraci.')

@section('content')
    <table class="table table-striped table-bordered table-responsive-md">
        <thead>
        <tr>
            <th>Meno</th>
            <th>Email</th>
            <th>Datum vytvoření</th>
            <th>Datum poslední změny</th>
            <th>Role</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse ($users as $user)
            <tr>
                <td>
                    <a href="{{ route('user.show', ['user' => $user]) }}">
                        {{ $user->name }}
                    </a>
                </td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->isoFormat('LLL') }}</td>
                <td>{{ $user->updated_at->isoFormat('LLL') }}</td>
                <td>
                    @if(isset($user->role))
                        {{$user->role->name}}
                    @endif
                </td>
                <td>
                    <a href="{{ route('user.edit', ['user' => $user]) }}">Editovat</a>
                    <a href="#" onclick="event.preventDefault(); $('#user-delete-{{ $user->id }}').submit();">Odstranit</a>

                    <form action="{{ route('user.destroy', ['user' => $user]) }}" method="POST" id="user-delete-{{ $user->id }}" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">
                    Ziadny uzivatelia
                </td>
            </tr>
        @endforelse
        @if($users->hasPages())
            <tr>
                <td align="center" colspan="5">{{ $users->links() }}</td>
            </tr>
        @endif
        </tbody>
    </table>
@endsection
