<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
					aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="{{url('/')}}">
				<img alt="SHerna logo" src="{{asset('assets_client/img/logo.jpg')}}" style="height: 100%">
			</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
                @foreach($nav_pages as $nav)
                    @if($nav->dropdown)
                        <li class="dropdown">
                             <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                                aria-expanded="false">
                                 {{$nav->name}}
                             </a>
                            <ul class="dropdown-menu">
                                @foreach($nav->subpages as $sub_nav)
                                <li class="{{isset($page) && $page->nav_subpage_id == $sub_nav->id ? 'active' : ''}}">
                                     <a href="{{url('/pages/' . $nav->url . '/' . $sub_nav->url)}}">{{$sub_nav->name}}</a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                    @elseif(!(isset($nav->special_code) && $nav->special_code == 'home'))
                        <li class="{{isset($page) && $page->nav_page_id == $nav->id ? 'active' : ''}}">
                            <a href="{{url('/pages/' . $nav->url)}}">{{$nav->name}}</a>
                        </li>
                    @endif
                @endforeach
{{--				<li class="dropdown">--}}
{{--					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"--}}
{{--					   aria-expanded="false">{{trans('general.navbar.about-project')}}</a>--}}
{{--					<ul class="dropdown-menu">--}}
{{--						@if(\App\Models\Page::whereCode('o-sherne')->first()->public)--}}
{{--							<li class="{{isset($page) && $page->code=='o-sherne'?'active':''}}">--}}
{{--								<a href="{{action('Client\ClientController@show','o-sherne')}}">{{getName('o-sherne')}}</a>--}}
{{--							</li>--}}
{{--						@endif--}}
{{--						@if(\App\Models\Page::whereCode('clenove')->first()->public)--}}
{{--							<li class="{{isset($page) && $page->code=='clenove'?'active':''}}">--}}
{{--								<a href="{{action('Client\ClientController@show','clenove')}}">{{getName('clenove')}}</a>--}}
{{--							</li>--}}
{{--						@endif--}}

{{--						@if(\App\Models\Page::whereCode('navody')->first()->public)--}}
{{--							<li class="{{isset($page) && $page->code=='navody'?'active':''}}">--}}
{{--								<a href="{{action('Client\ClientController@show','navody')}}">{{getName('navody')}}</a>--}}
{{--							</li>--}}
{{--						@endif--}}

{{--						@if(\App\Models\Page::whereCode('provozni-rad')->first()->public)--}}
{{--							<li class="{{isset($page) && $page->code=='provozni-rad'?'active':''}}">--}}
{{--								<a href="{{action('Client\ClientController@show','provozni-rad')}}">{{getName('provozni-rad')}}</a>--}}
{{--							</li>--}}
{{--						@endif--}}

{{--						@if(\App\Models\Page::whereCode('vyrocni-spravy')->first()->public)--}}
{{--							<li class="{{isset($page) && $page->code=='vyrocni-spravy'?'active':''}}">--}}
{{--								<a href="{{action('Client\ClientController@show','vyrocni-spravy')}}">{{getName('vyrocni-spravy')}}</a>--}}
{{--							</li>--}}
{{--						@endif--}}

{{--					</ul>--}}
{{--				</li>--}}
{{--				@if(\App\Models\Page::whereCode('rezervace')->first()->public)--}}
{{--					<li class="{{isset($page) && $page->code=='rezervace'?'active':''}}"><a--}}
{{--								href="{{action('Client\ClientController@show','rezervace')}}">{{getName('rezervace')}}</a>--}}
{{--					</li>--}}
{{--				@endif--}}

{{--				@if(\App\Models\Page::whereCode('turnaje')->first()->public)--}}
{{--					<li class="{{isset($page) && $page->code=='turnaje'?'active':''}}"><a--}}
{{--								href="{{action('Client\ClientController@show','turnaje')}}">{{getName('turnaje')}}</a>--}}
{{--					</li>--}}
{{--				@endif--}}

{{--				@if(\App\Models\Page::whereCode('vybaveni')->first()->public)--}}
{{--					<li class="{{isset($page) && $page->code=='vybaveni'?'active':''}}"><a--}}
{{--								href="{{action('Client\ClientController@show','vybaveni')}}">{{getName('vybaveni')}}</a>--}}
{{--					</li>--}}
{{--				@endif--}}
				<li>
					<a href="https://www.facebook.com/pg/SHernaSiliconHill/photos" target="_blank"
					   rel="noopener">{{trans('general.navbar.foto')}}</a>
				</li>

				@auth
{{--					<li class="dropdown">--}}
{{--						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"--}}
{{--						   aria-expanded="false">{{Auth::user()->name}} {{Auth::user()->surname}}</a>--}}
{{--						<ul class="dropdown-menu">--}}
{{--							<li class="{{$_SERVER['REQUEST_URI']=='/uzivatel/rezervace'?'active':''}}">--}}
{{--								<a href="{{action('Client\ClientController@getReservations')}}">{{trans('navbar.my_reservations')}}</a>--}}
{{--							</li>--}}
{{--							<li class="{{$_SERVER['REQUEST_URI']=='/uzivatel/odznaky'?'active':''}}">--}}
{{--								<a href="{{action('Client\ClientController@getBadges')}}">{{trans('navbar.my_badges')}}</a>--}}
{{--							</li>--}}
{{--							<li>--}}
{{--								<a href="{{action('Client\ClientController@getLogout')}}">{{trans('navbar.logout')}}</a>--}}
{{--							</li>--}}


							@if(Auth::user()->isAdmin())
								<li class="divider" role="separator"></li>
								<li><a href="{{'Admin\AdminController@index'}}">Admin</a></li>
							@endif
						</ul>
					</li>
				@else
					<li>
						<a href="Client\ClientController@getAuthorize">{{trans('general.navbar.login')}}</a>
					</li>
				@endauth
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
					   aria-expanded="false">
						<span class="flag-icon flag-icon-{{Session::get('lang') =='en' ? 'gb':Session::get('lang')}}"></span>
					</a>
					<ul class="dropdown-menu">
                        @foreach($languages as $lang)
                            <li>
                                <a  href="{{route('language', [$lang->code])}}">
                                    <span class="flag-icon flag-icon-{{$lang->code == 'en' ? 'gb' : $lang->code}}"></span>{{$lang->name}}</a>
                            </li>
                        @endforeach

					</ul>
				</li>
			</ul>
		</div><!--/.nav-collapse -->
	</div>
</nav>
