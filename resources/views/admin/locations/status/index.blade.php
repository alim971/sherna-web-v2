<div class="col-md-4">
    <div class="x_panel">
        <div class="x_title">
            <h2>Locations statuses</h2>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('status.create') }}"><i class="fa fa-plus"></i></a>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Opened</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($statuses as $status)
                    <tr>
                        <td>{{$status->status}}</td>
                        <td>
                            <span class="label label-{{$status->opened ? 'success':'danger'}}">{{$status->opened ? 'Opened':'Closed'}}</span>
                        </td>
                        <td>
                            <form action="{{ route('status.destroy',$status->id) }}" class="inline" method="post">
                                @csrf
                                @method('DELETE')
                                <a class="btn btn-warning" href="{{route('status.edit',$status->id)}}"><i
                                            class="fa fa-pencil"></i></a>
                                <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">
                            No statuses so far
                        </td>
                    </tr>
                @endforelse
                @if($statuses->hasPages())
                    <tr>
                        <td class="text-center" colspan="3">{{ $statuses->links() }}</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
