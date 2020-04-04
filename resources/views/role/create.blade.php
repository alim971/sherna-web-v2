@extends('base')

@section('title', 'Tvorba role')
@section('description', 'Editor pro vytvoření novej role.')

@section('content')
    <h1>Tvorba role </h1>

    <form action="{{ route('role.store') }}" method="POST">
        @csrf
        <div>
            <div class="form-group">
                <label for="name">Meno</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required minlength="3" maxlength="80" />
            </div>

            <div class="form-group">
                <label for="description">Popis</label>
                <input type="text" name="description" id="description" class="form-control" value="{{ old('description') }}" required minlength="3" maxlength="80" />
            </div>

            <div class="form-group">
                <label for="permissions[]">Role</label>
                <br/>
                <select id="permission" name="permissions[]" multiple>
                    @foreach(\App\Permission::all() as $permission)
                        <option title="{{$permission->description}}" value="{{$permission->id}}">
                            {{$permission->name ?? $permission->controller . '@' . $permission->method}}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Vytvorit rolu</button>
        </div>
    </form>

@endsection

