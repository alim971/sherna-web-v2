@extends('layouts.admin')

@section('content')

    <form action="{{action('Admin\GamesController@update',$game->id)}}" class="form-horizontal" method="post">
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-md-12">
                @include('admin.partials.form_errors')

                <div class="x_panel">
                    <div class="x_title">
                        <h2>Edit game</h2>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i></button>
                            <a href="{{action('Admin\GamesController@index')}}" class="btn btn-danger"><i class="fa fa-times"></i></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-4 control-label">Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="input1" name="name" value="{{$game->name}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input2" class="col-sm-4 control-label">Max possible players</label>
                                    <div class="col-sm-8">
                                        <input type="number" min="1" class="form-control" id="input2" name="possible_players" value="{{$game->possible_players}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input2" class="col-sm-4 control-label">Console type</label>
                                    <div class="col-sm-8">
                                        <select name="console_type_id" id="input2" class="form-control">
                                            @foreach(\App\Models\ConsoleType::get() as $consoleType)
                                                <option value="{{$consoleType->id}}" {{$game->consoleType->id == $consoleType->id ? 'selected':''}}>{{$consoleType->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input2" class="col-sm-4 control-label">Location</label>
                                    <div class="col-sm-8">
                                        <select name="location_id[]" id="input2" class="form-control" multiple>
                                            @foreach(\App\Models\Location::get() as $location)
                                                <option value="{{$location->id}}" {{$game->locations->contains($location) ? 'selected':''}}>{{$location->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection