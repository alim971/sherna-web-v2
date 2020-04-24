
<table class="table table-striped table-bordered table-responsive-md">
    <thead>
    <tr>
        <th>Name</th>
        <th>Url</th>
        <th>Order</th>
        <th>Public</th>
        {{--                                <th>Datum vytvoření</th>--}}
        {{--                                <th>Datum poslední změny</th>--}}
        <th></th>
    </tr>
    </thead>
    <tbody>
    @forelse($subpages as $sub)
        <tr>
            <td>
                {{ $sub->name }}
            </td>
            <td>{{ $sub->url }}</td>
            <td>{{ $sub->order }}</td>
            <td>{{ $sub->public }}</td>
            {{--                                    <td>{{ $sub->created_at->isoFormat('LLL') }}</td>--}}
            {{--                                    <td>{{ $sub->updated_at->isoFormat('LLL') }}</td>--}}
            <td>
                <a href="#" class="click-modal" data-toggle="modal" data-target="#view-modal"
                   data-url="{{ route('subnavigation.edit', ['subnavigation' => $sub->url])}}">Editovat</a>
                <a href="{{ route('subnavigation.public', ['subnavigation' => $sub->url])}}">Make public</a>
                <a href="#" class="delete" data-url="{{route('subnavigation.destroy', ['subnavigation' => $sub->url]) }}">Odstranit</a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center">
                Nikdo zatím nevytvořil ziadnu podstranku.
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
@include('modal.button-modal', [
    'route' => route('subnavigation.create'),
    'btnText' => 'Pridaj podstranku',
    ])

