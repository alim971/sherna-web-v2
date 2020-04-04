@extends('base')

@section('title', 'Editace permission ' . $permission->name)
@section('description', 'Editor pro editaci permission.')

@section('content')
    <h1>Editace permission {{ $permission->name }}</h1>

    <form action="{{ route('permission.update', ['permission' => $permission]) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <div class="form-group">
                <label for="name">Meno</label>
                <input type="text" name="name" id="name" class="form-control" value="{{$permission->name ?: old('name') }}" required minlength="3" maxlength="80" />
            </div>

            <div class="form-group">
                <label for="description">Popis</label>
                <input type="text" name="description" id="description" class="form-control" value="{{$permission->description ?: old('description') }}" required minlength="3" maxlength="80" />
            </div>

            <div class="form-group">
                <label for="controller">Controller</label>
                <input name="controller" id="controller" value="{{$permission->controller ?: old('controller') }}" readonly/>
            </div>

            <div class="form-group">
                <label for="method">Method</label>
                <input type="text" name="method" id="method" value="{{$permission->method ?: old('method') }}" readonly/>
            </div>
            <button type="submit" class="btn btn-primary">Uložit permission</button>
        </div>
    </form>

@endsection

