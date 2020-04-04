@extends('base')

@section('title', 'Editace usera ' . $user->name)
@section('description', 'Editor pro editaci usera.')

@section('content')
    <h1>Editace článku {{ $user->title }}</h1>

    <form action="{{ route('user.update', ['user' => $user]) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <div class="form-group">
                <label for="name">Meno</label>
                <input type="text" name="name" id="name" class="form-control" value="{{$user->name ?: old('name') }}" required minlength="3" maxlength="80" />
            </div>

            <div class="form-group">
                <label for="email">Meno</label>
                <input type="text" name="email" id="email" class="form-control" value="{{$user->email ?: old('email') }}" required minlength="3" maxlength="80" />
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role">
                    @foreach(\App\Role::all() as $role)
                        <option value="{{$role->id}}" {{ $role->id == $user->role->id ? 'selected' : ''}}>
                            {{$role->name}}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Uložit uzivatela</button>
        </div>
    </form>

@endsection

