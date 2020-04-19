@extends('layouts.admin')

@section('content')

	<div class="row">
		<div class="col-md-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Permissions</h2>
{{--                    TODO: If super user--}}
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('permission.generate') }}"><i class="fa fa-plus"></i></a>
                    </div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">

					<table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Controller</th>
                            <th>Method</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($permissions as $permission)
                            <tr>
                                <td>
                                    {{ $permission->name }}
                                </td>
                                <td>{{ $permission->description }}</td>
                                <td>{{ $permission->controller }}</td>
                                <td>{{ $permission->method }}</td>
                                <td>{{ $permission->created_at->isoFormat('LLL') }}</td>
                                <td>{{ $permission->updated_at->isoFormat('LLL') }}</td>
                                <td>
                                    <form action="{{ route('permission.destroy',$permission) }}" class="inline" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('permission.edit', ['permission' => $permission]) }}"
                                           class="btn btn-default"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    No permissions yet
                                </td>
                            </tr>
                        @endforelse
                        @if($permissions->hasPages())
                            <tr>
                                <td class="text-center" colspan="7">{{ $permissions->links() }}</td>
                            </tr>
                        @endif
                        </tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

@endsection
