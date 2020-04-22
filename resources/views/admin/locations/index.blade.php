@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-8">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Locations</h2>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('location.create') }}"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Location UID</th>
                            <th>Reader UID</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($locations as $location)
                            <tr>
                                <td>{{$location->name}}</td>
                                <td>
                                    <span class="label label-{{$location->status->opened ? 'success':'danger'}}">{{$location->status->name}}</span>
                                </td>
                                <td>{{$location->location_uid}}</td>
                                <td>{{$location->reader_uid}}</td>
                                <td>
                                    <form action="{{ route('location.destroy',$location->id) }}" class="inline" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a class="btn btn-warning" href="{{ route('location.edit', $location->id) }}"><i
                                                    class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    No locations so far.
                                </td>
                            </tr>
                        @endforelse
                        @if($locations->hasPages())
                            <tr>
                                <td class="text-center" colspan="5">{{ $locations->links() }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @include('admin.locations.status.index', ['statuses' => $statuses])

    </div>

@endsection
