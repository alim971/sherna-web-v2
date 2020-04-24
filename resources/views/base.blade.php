<!DOCTYPE html>
<html lang="cs-CZ">
<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description" content="@yield('description')" />
    <title>@yield('title', env('APP_NAME'))</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/style.css')}}" rel="stylesheet">
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">


    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/smalot-bootstrap-datetimepicker/2.4.4/js/bootstrap-datetimepicker.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/smalot-bootstrap-datetimepicker/2.4.4/css/bootstrap-datetimepicker.min.css">

</head>
<body>

<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <h5 class="my-0 mr-md-auto font-weight-normal">{{ env('APP_NAME') }}</h5>
    <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-dark" href="{{route('user.index')}}">Uzivatelia</a>
        <a class="p-2 text-dark" href="{{route('role.index')}}">Rola</a>
        <a class="p-2 text-dark" href="{{route('permission.index')}}">Prava</a>
        <a class="p-2 text-dark" href="{{route('location.index')}}">Location</a>
        <a class="p-2 text-dark" href="{{route('status.index')}}">Location Status</a>
        <a class="p-2 text-dark" href="{{route('article.index')}}">Articles</a>
        <a class="p-2 text-dark" href={{route('reservation.index')}}>Rezervace</a>
        @foreach($nav_pages as $nav)
            @if($nav->dropdown)
                <span>
                    <a href="#" class="p-2 text-dark dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">{{$nav->name}}</a>
                    <ul class="dropdown-menu">
                @foreach($nav_subpages as $sub_nav)
                    @if($sub_nav->nav_page_id == $nav->id)
                        <li>
                            <a class="p-2 text-dark" href="{{url('/pages/' . $nav->url . '/' . $sub_nav->url)}}">{{$sub_nav->name}}</a>
                        </li>
                    @endif
                @endforeach
                    </ul>
                </span>
            @else
                <a class="p-2 text-dark" href="{{url('/pages/' . $nav->url)}}">{{$nav->name}}</a>
            @endif
        @endforeach
        @guest
                <a class="p-2 text-dark" href="{{ route('login') }}">{{ __('Login') }}</a>
            @if (Route::has('register'))
                    <a class="p-2 text-dark" href="{{ route('register') }}">{{ __('Register') }}</a>
            @endif
        @else
            <span>
                <a id="navbarDropdown" class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item p-2 text-dark" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </span>
        @endguest
            <span>
                    <a href="#" class="p-2 text-dark dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">{{$active_lang}}</a>
                    <ul class="dropdown-menu">
                        @foreach($languages as $lang)
                        <li>
                            <a class="p-2 text-dark" href="{{route('language', [$lang->code])}}">{{$lang->code}}</a>
                        </li>
                        @endforeach
                    </ul>
                </span>
    </nav>
</div>

<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')

    <footer class="pt-4 my-md-5 border-top">
        @yield('footer')
        <p>
            Ukázkový jednoduchý redakční systém v Laravel frameworku
        </p>
    </footer>
</div>

@stack('scripts')
</body>
</html>
