@extends('layouts.client')

@section('title', 'Seznam článků')
@section('description', 'Výpis všech článků v administraci.')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-xs-12">
            @include('client.blog.partials.articles', ['articles' => $articles])
        </div>
    </div>
@endsection
