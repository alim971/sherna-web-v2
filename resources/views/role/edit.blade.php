@extends('base')

@section('title', 'Editace role ' . $role->name)
@section('description', 'Editor pro editaci rolea.')

@section('content')
    <h1>Editace role {{ $role->name }}</h1>

    <form action="{{ route('role.update', ['role' => $role]) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <div class="form-group">
                <label for="name">Meno</label>
                <input type="text" name="name" id="name" class="form-control" value="{{$role->name ?: old('name') }}" required minlength="3" maxlength="80" />
            </div>

            <div class="form-group">
                <label for="description">Popis</label>
                <input type="text" name="description" id="description" class="form-control" value="{{$role->description ?: old('description') }}" required minlength="3" maxlength="80" />
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <br/>
                <select id="permission" name="permissions[]" multiple>
                    @foreach(\App\Permission::all() as $permission)
                        <option value="{{$permission->id}}" title="{{$permission->description}}" {{ !! $role->hasPermission($permission) ? 'selected' : ''}}>
                            {{$permission->name ?? $permission->controller . '@' . $permission->method}}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Uložit rolu</button>
        </div>
    </form>

@endsection

