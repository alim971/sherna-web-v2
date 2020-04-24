@extends('layouts.admin')

@section('content')

	<div class="row">
		<div class="col-md-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Inventory categories</h2>
					<div class="pull-right">
						<a class="btn btn-primary" href="{{ route('inventory.category.create') }}"><i
									class="fa fa-plus"></i></a>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">

					<table class="table">
						<thead>
						<tr>
							<th>Name</th>
							<th></th>
						</tr>
						</thead>
						<tbody>
						@forelse($inventoryCategories as $inventoryCategory)
							<tr>
								<td>{{$inventoryCategory->name}}</td>
								<td>
									<form action="{{ route('inventory.category.destroy', ['category' => $inventoryCategory->id]) }}"
										  class="inline" method="post">
										@csrf
                                        @method('DELETE')
										<a class="btn btn-warning"
										   href="{{ route('inventory.category.edit', ['category' => $inventoryCategory->id]) }}"><i
													class="fa fa-pencil"></i></a>
											<button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i>
											</button>
									</form>
								</td>
							</tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="2">No categories yet</td>
                            </tr>
                        @endforelse
                        @if($inventoryCategories->hasPages())
                            <tr>
                                <td class="text-center" colspan="2">{{ $inventoryCategories->links() }}</td>
                            </tr>
                        @endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

@endsection
