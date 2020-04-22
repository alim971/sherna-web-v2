
@foreach(\App\Location::all() as $location)
    <div class="row" id="location">
        <h2 data-toggle="collapse" data-parent="#inventory-items" class="collapsed"
        href="#collapse{{$location->id}}" aria-expanded="true"
        aria-controls="collapse{{$location->id}}">
            {{$location->name}}
            <i class="fa fa-chevron-circle-down cursor"></i>
        </h2>
        <div class="collapse in" id="collapse{{$location->id}}">
            <div class="col-md-12 inventory-items" id="inventory-items">
                <h2>
                    {{trans('general.content.games')}}
                </h2>
                <hr>
                @foreach(\App\Console::all() as $console)
                    <h3 data-toggle="collapse" data-parent="#inventory-items" class="collapsed"
                        href="#collapse{{$console->id}}-{{$location->id}}" aria-expanded="true"
                        aria-controls="collapse{{$console->id}}">
                        {{$console->name}}
                        <i class="fa fa-chevron-circle-down cursor"></i>
                    </h3>
                    <div class="collapse" id="collapse{{$console->id}}-{{$location->id}}">
                            @foreach($console->games as $game)
                            <div class="game-item">
                                                <span class="game-name">
                                                    <b>{{$game->name}}</b>
                                                </span>
                                <ul class="game-options">
                                    <li>{{trans('games.players')}}: <span
                                            class="label label-default">{{$game->possible_players}}</span>
                                    </li>
                                    @if(Str::contains(strtolower($console->type->name), 'playstation'))
                                        <li>{{trans('games.vr')}}: <span
                                                class="label label-{{$game->vr ? 'success' : 'danger'}}">{{$game->vr ? trans('general.yes') : trans('general.no')}}</span>
                                        </li>
                                        <li>{{trans('games.move')}}: <span
                                                class="label label-{{$game->move ? 'success' : 'danger'}}">{{$game->move ? trans('general.yes') : trans('general.no')}}</span>
                                        </li>
                                    @endif
                                    <li>{{trans('games.game_pad')}}: <span
                                            class="label label-{{$game->game_pad ? 'success' : 'danger'}}">{{$game->game_pad ? trans('general.yes') : trans('general.no')}}</span>
                                    </li>
                                    @if(Str::contains(strtolower($console->type->name),'xbox'))
                                        <li>{{trans('games.kinect')}}: <span
                                                class="label label-{{$game->kinect ? 'success' : 'danger'}}">{{$game->kinect ? trans('general.yes') : trans('general.no')}}</span>
                                        </li>
                                        <li>{{trans('games.guitar')}}: <span
                                                class="label label-{{$game->guitar ? 'success' : 'danger'}}">{{$game->guitar ? trans('general.yes') : trans('general.no')}}</span>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        @endforeach
                    </div>
            @endforeach


        @foreach(\App\InventoryCategory::get() as $category)
            <div class="row">
                <div class="col-md-12 inventory-items" id="inventory-items">
                    <h2>
                        {{$category->name}}
                    </h2>

                    <hr>
                    <ul>
                        @foreach($category->items as $categoryItem)
                            <li>
                                {{$categoryItem->name}}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
    @endforeach
            </div>
        </div>
    </div>
@endforeach
