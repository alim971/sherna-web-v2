@extends('base')

@section('title', $role->name)
@section('description', $role->description)

@section('content')
    <h1> {{ $role->name }}</h1>
    <div>
        <p>{{ $role->description }}</p>
    </div>
    <table>
        <caption>Permissions</caption>
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Controller</th>
                <th>Method</th>
            </tr>
        </thead>
        <tbody>
        @foreach(\App\Permission::all() as $permission)
            <tr>
                <td>{{ $permission->name }}</td>
                <td>{{ $permission->description }}</td>
                <td>{{ $permission->controller }}</td>
                <td>{{ $permission->method }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

