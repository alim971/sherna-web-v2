
    <h1>Tvorba článku</h1>

    <form action="{{ route('reservation.store') }}" method="POST">
        @csrf
        <div>
            <div class="form-group">
                <label for="location">Location</label>
                <select name="location" id="location" required>
                    @foreach(\App\Location::all() as $location)
                        <option value="{{$location->id}}" {{$location->id == 1 ? "selected" : ""}}>
                            {{$location->name}}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="start">Start</label>
                <input name="start" class="form-control form_datetime" id="start" type="text" required readonly>
            </div>
            <div class="form-group">
                <label for="end">End</label>
                <input name="end" class="form-control form_datetime" id="end" type="text" required readonly>
            </div>
            @auth
                @if(\Auth::user()->role->hasPermissionByName("vr"))
                    <div class="form-group">
                        <label for="vr">VR</label>
                        <input type="checkbox" name="vr" id="vr"/>
                    </div>
                @endif
            @endauth
            <button type="submit" class="btn btn-primary">Uložit rezervaciu</button>
        </div>
    </form>

@include('reservation.scripts.datetimepicker', ['lang' => \Session::get('lang')])
