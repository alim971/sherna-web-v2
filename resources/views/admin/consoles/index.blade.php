@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-8">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Consoles</h2>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('console.create') }}"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Location</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($consoles as $console)
                            <tr>
                                <td>
                                    {{$console->name}}
                                </td>
                                <td>
                                    {{$console->type->name}}
                                </td>
                                <td>
                                    {{$console->location->name}}
                                </td>
                                <td>
                                    <form action="{{ route('console.destroy', ['console' => $console]) }}" class="inline" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a class="btn btn-warning" href="{{ route('console.edit', ['console' => $console])}}"><i
                                                    class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="4"> No consoles yet </td>
                            </tr>
                        @endforelse
                        @if($consoles->hasPages())
                            <tr>
                                <td class="text-center" colspan="4">{{ $consoles->links() }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @include('admin.consoles.types.index', ['consoleTypes' => $consoleTypes])
    </div>
@endsection
