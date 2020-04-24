@extends('layouts.client')
@section('content')
        <div class="flex-center position-ref full-height">
            <div class="code">
                <h1>@yield('code')</h1>
            </div>

            <div class="message" style="padding: 10px;">
                <h2>@yield('message')</h2>
            </div>
        </div>
@endsection
