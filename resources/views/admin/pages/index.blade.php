@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Pages</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Public</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($pages as $page)
                            <tr>
                                <td>{{$page->name}}</td>
                                <td><span class="label label-{{$page->public ? 'success':'warning'}}">{{$page->public ? 'Public':'In prepare'}}</span></td>
                                <td>
                                    <form action="{{ route('page.destroy', ['page' => $page->id, 'type' => $type]) }}" class="inline" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a class="btn btn-warning" href="{{ route('page.edit' ,['page' => $page->id, 'type' => $type]) }}"><i
                                                class="fa fa-pencil"></i></a>
                                        @if($page->special_code != 'home')
                                            <a href="{{ route('page.public', ['page' => $page->id, 'type' => $type]) }}" class="btn btn-{{$page->public ? "danger" : "primary"}} primary"><i
                                                    class="fa {{$page->public ? "fa-eye-slash" : "fa-eye"}} "></i></a>
                                        @endif
                                        @if(!isset($page->special_code))
                                            <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="3">No page yet</td>
                            </tr>
                        @endforelse
                        @if($pages->hasPages())
                            <tr>
                                <td class="text-center" colspan="3">{{ $pages->links() }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
