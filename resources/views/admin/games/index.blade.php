@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Games</h2>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('game.create') }}"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Max possible players</th>
                            <th>Console</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($games as $game)
                            <tr>
                                <td>{{$game->name}}</td>
                                <td>{{$game->possible_players}}</td>
                                <td>{{$game->console->name}}</td>
                                <td>
                                    <form action="{{ route('game.destroy', ['game' => $game]) }}" class="inline" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a class="btn btn-warning" href="{{ route('game.edit', ['game' => $game]) }}"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="4"> No games yet </td>
                            </tr>
                        @endforelse
                        @if($games->hasPages())
                            <tr>
                                <td class="text-center" colspan="4">{{ $games->links() }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
