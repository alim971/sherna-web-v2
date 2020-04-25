{{session()->has('flash_notification.message') ? "AA" : "BB"}}
@if (session()->has('flash_notification.message'))
    bbbb
    <div class="speech-container">
        <div class="speech speech-{{ Session::get('flash_notification.level') }} hidden">
            <p>
                {!!  Session::get('flash_notification.message')  !!}
            </p>
        </div>
    </div>
@endif
