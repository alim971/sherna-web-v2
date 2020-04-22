@extends('layouts.client')

@section('content')

	<main class="container">

		<div class="row">
			<div class="col-md-12 col-xs-12">
                <h1>{{$page->title}}</h1>
                {!!$page->content !!}
			</div>
		</div>
    @if(isset($page->special_code))
        @include('client.pages.special_pages.'. $page->special_code)
    @endif
    </main>


@endsection
