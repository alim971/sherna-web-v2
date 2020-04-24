@extends('layouts.admin')

@section('content')

    <form action="{{ route('settings.update') }}" class="form-horizontal" method="post">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-12">
                @include('admin.partials.form_errors')

                <div class="x_panel">
                    <div class="x_title">
                        <h2>System settings</h2>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-12">
                                @foreach ($settings as $setting)
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" for="value-{{$setting->id}}">{{$setting->name}}</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="number" name="value-{{$setting->id}}" id="value-{{$setting->id}}" class="form-control" value="{{$setting->value ?: old('value-' .$setting->id) }}" required />
                                                <span class="input-group-addon" id="basic-addon2">{{$setting->unit}}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
{{--                                <div class="form-group">--}}
{{--                                    <label for="value-1" class="col-sm-4 control-label">Max duration of reservation</label>--}}
{{--                                    <div class="col-sm-8">--}}
{{--                                        <div class="input-group">--}}
{{--                                            <input type="text" class="form-control" id="value-1" name="value-1" value="{{config('calendar.max-duration')}}">--}}
{{--                                            <span class="input-group-addon" id="basic-addon2">hours</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="value-2" class="col-sm-4 control-label">Time before start to edit</label>--}}
{{--                                    <div class="col-sm-8">--}}
{{--                                        <div class="input-group">--}}
{{--                                            <input type="text" class="form-control" id="value-2" name="value-2"--}}
{{--                                                   value="{{intval(config('calendar.duration-for-edit'))}}">--}}
{{--                                            <span class="input-group-addon" id="basic-addon2">minutes</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="value-3" class="col-sm-4 control-label">Accessible reservation area</label>--}}
{{--                                    <div class="col-sm-8">--}}
{{--                                        <div class="input-group">--}}
{{--                                            <input type="text" class="form-control" id="value-3" name="value-3"--}}
{{--                                                   value="{{config('calendar.reservation-area')}}">--}}
{{--                                            <span class="input-group-addon" id="basic-addon2">days</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="value-4" class="col-sm-4 control-label">Earlier access to location of reservation</label>--}}
{{--                                    <div class="col-sm-8">--}}
{{--                                        <div class="input-group">--}}
{{--                                            <input type="text" class="form-control" id="value-4" name="value-4"--}}
{{--                                                   value="{{config('calendar.access_to_location')}}">--}}
{{--                                            <span class="input-group-addon" id="basic-addon2">minutes</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="value-5" class="col-sm-4 control-label">Time before end to renew reservation</label>--}}
{{--                                    <div class="col-sm-8">--}}
{{--                                        <div class="input-group">--}}
{{--                                            <input type="text" class="form-control" id="value-5" name="value-5"--}}
{{--                                                   value="{{config('calendar.renew_reservation')}}">--}}
{{--                                            <span class="input-group-addon" id="basic-addon2">minutes</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
