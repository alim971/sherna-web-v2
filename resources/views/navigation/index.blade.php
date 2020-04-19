@extends('base')

@section('title', 'Seznam miestnosti')
@section('description', 'Výpis všech miestnosti v administraci.')

@section('content')
    <table class="table table-striped table-bordered table-responsive-md">
        <thead>
        <tr>
            <th>Name</th>
            <th>Url</th>
            <th>Order</th>
            <th>Public</th>
            <th>Subpages</th>
{{--            <th>Page</th>--}}
{{--            <th>Datum vytvoření</th>--}}
{{--            <th>Datum poslední změny</th>--}}
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse ($pages as $page)
            <tr>
                <td>
                        {{ $page->name }}
                </td>
                <td>{{ $page->url }}</td>
                <td>{{ $page->order }}</td>
                <td>{{ $page->public }}</td>
                <td>
                    @if($page->dropdown)
                        @foreach($page->subpages as $pa)
                            {{$pa->name}},
                        @endforeach
                    @else
                        Is not dropdown
                    @endif
                </td>
{{--                <td>{{ $page->created_at->isoFormat('LLL') }}</td>--}}
{{--                <td>{{ $page->updated_at->isoFormat('LLL') }}</td>--}}
                <td>
                    <a href="{{ route('navigation.edit', ['navigation' => $page->id]) }}">Editovat</a>
                    <a href="{{ route('navigation.public', ['navigation' => $page->id]) }}">Make public</a>
                    <a href="#" onclick="event.preventDefault(); $('#navigation-delete-{{ $page->url }}').submit();">Odstranit</a>

                    <form action="{{ route('navigation.destroy', ['navigation' => $page->id]) }}" method="POST" id="navigation-delete-{{ $page->url }}" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">
                    Nikdo zatím nevytvořil ziadnu navigaciu.
                </td>
            </tr>
        @endforelse
        @if($pages->hasPages())
            <tr>
                <td class="text-center" colspan="5">{{ $pages->links() }}</td>
            </tr>
        @endif
        </tbody>
    </table>

    <a href="{{ route('navigation.create') }}" class="btn btn-primary">
        Vytvořit novu navigaciu
    </a>
@endsection
