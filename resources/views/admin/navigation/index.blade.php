@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Navigation</h2>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('navigation.create') }}"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <table id="sorting_table" class="table sorted_table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Url</th>
                            <th>Order</th>
                            <th>Public</th>
                            <th>Dropdown pages</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($navigations as $navigation)
                            <tr>
                                <td>{{ $navigation->name }}</td>
                                <td>{{ $navigation->url }}</td>
                                <td>{{ $navigation->order }}</td>
                                <td><span class="label label-{{$navigation->public ? 'success':'warning'}}">{{$navigation->public ? 'Public':'In prepare'}}</span></td>
                                <td>
                                    @if($navigation->dropdown)
                                        @forelse($navigation->subpages as $subpage)
                                            <span class="label label-info">{{ $subpage->name }}</span>
                                        @empty
                                            <span class="label label-warning"> No subpages</span>
                                        @endforelse
                                    @else
                                            <span class="label label-info" >Is not dropdown</span>
                                     @endif
                                </td>
{{--                                <td>{{ $navigation->user->name }}</td>--}}
                                <td></td>
                                <td>
                                    <form action="{{ route('navigation.destroy', ['navigation' => $navigation->id]) }}" class="inline" method="post">
                                        @csrf
                                        @method('DELETE')
                                        @if(!isset($navigation->special_code))
                                            <a class="btn btn-warning" href="{{ route('navigation.edit' ,['navigation' => $navigation->id]) }}"><i
                                                class="fa fa-pencil"></i></a>
                                            <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                        @endif
                                        @if($navigation->special_code != 'home')
                                             <a href="{{ route('navigation.public', ['navigation' => $navigation->id]) }}" class="btn btn-{{$navigation->public ? "danger" : "primary"}} primary"><i
                                                class="fa {{$navigation->public ? "fa-eye-slash" : "fa-eye"}} "></i></a>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="7">No navigation yet</td>
                            </tr>
                        @endforelse
                        @if($navigations->hasPages())
                            <tr>
                                <td class="text-center" colspan="7">{{ $navigations->links() }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@include('admin.assets.sortable', ['selector' => '.sorted_table', 'id' => 'sorting_table', 'route' => route('navigation.reorder') ]);
