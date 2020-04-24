@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Categories</h2>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('category.create') }}"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $category->detail->name }}</td>
                                <td>{{ $category->created_at->isoFormat('LLL') }}</td>
                                <td>{{ $category->updated_at->isoFormat('LLL') }}</td>
                                <td></td>
                                <td>
                                    <form action="{{ route('category.destroy',['category' => $category]) }}" class="inline" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a class="btn btn-warning" href="{{ route('category.edit' ,['category' => $category]) }}"><i
                                                class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="4">No categories yet</td>
                            </tr>
                        @endforelse
                        @if($categories->hasPages())
                            <tr>
                                <td class="text-center" colspan="4">{{ $categories->links() }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
