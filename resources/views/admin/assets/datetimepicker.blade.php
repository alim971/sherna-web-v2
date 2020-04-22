@push('styles')
    <link href="{{asset('assets_client/datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{asset('assets_admin/js/datetimepicker/js/bootstrap-datetimepicker.js')}}"></script>

    <script type="text/javascript">
        var formDate = $(".form_datetime").datetimepicker({
            language      : pickerLocale,
            format        : "dd.mm.yyyy hh:ii:00",
            autoclose     : true,
            startDate     : moment().add(durationforedit, 'm').format('YYYY-MM-DD HH:mm'),
            todayBtn      : true,
            todayHighlight: false,
            fontAwesome   : true,
            pickerPosition: "bottom-left",
            minuteStep    : 15
        });


        var toDate = $(".to_datetime").datetimepicker({
            language      : pickerLocale,
            format        : "dd.mm.yyyy hh:ii:00",
            autoclose     : true,
            startDate     : moment().add(durationforedit * 2, 'm').format('YYYY-MM-DD HH:mm'),
            todayBtn      : true,
            todayHighlight: false,
            fontAwesome   : true,
            pickerPosition: "bottom-right",
            minuteStep    : 15
        });
    </script>
@endpush
