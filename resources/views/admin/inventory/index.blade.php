@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Inventory items</h2>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('inventory.create') }}"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Serial number</th>
                            <th>Inventory number</th>
                            <th>Location</th>
                            <th>Note</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($inventoryItems as $inventoryItem)
                            <tr>
                                <td>{{$inventoryItem->name}}</td>
                                <td>{{$inventoryItem->category->name}}</td>
                                <td>{{$inventoryItem->serial_id}}</td>
                                <td>{{$inventoryItem->inventory_id}}</td>
                                <td>{{$inventoryItem->location->name}}</td>
                                <td>{{$inventoryItem->note}}</td>
                                <td>
                                    <form action="{{ route('inventory.destroy', ['inventory' => $inventoryItem->id]) }}" class="inline" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a class="btn btn-warning" href="{{ route('inventory.edit', ['inventory' => $inventoryItem->id]) }}"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="7"> No items yet </td>
                                </tr>
                            @endforelse
                            @if($inventoryItems->hasPages())
                                <tr>
                                    <td class="text-center" colspan="7">{{ $inventoryItems->links() }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
