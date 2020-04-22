@push('scripts')
    <script src="{{asset('gentellela/fullcalendar.js')}}"></script>
    <script src="{{asset('gentellela/fullcalendar-locale.js')}}"></script>

    <script>
        var reservationarea              = '10';//Settings;
        var durationforedit              = '10'; //Settings;
        var maxeventduration             = '8'; //Settings
        var myReservationColor           = '{{config('calendar.my-reservation.color')}}';
        var myReservationBorderColor     = '{{config('calendar.my-reservation.border-color')}}';
        var myReservationBackgroundColor = '{{config('calendar.my-reservation.background-color')}}';

        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                }
            });
            saveReservation();
            initCalendar();
            initOnChangeLocation();
            showCalenderIfOpened();
        });

        function createEvent(start, end) {
            $('.form_datetime').val(start.format('DD.MM.YYYY HH:mm:00'));
            $('.to_datetime').val(end.format('DD.MM.YYYY HH:mm:00'));
            $('#location_id').val($('[name="location"]:checked').val());
            $('#createReservationModal').modal('show');

        }

        function controlEventTimes(start, end) {
            // if (Math.abs(start.diff(end, 'days')) !== 0) {
            //     $('#calendar').fullCalendar('unselect');
            //     alert('Make 2 separate reservations for this operation.');
            //     return false;
            // }
            if (Math.abs(start.diff(end, 'hours')) > maxeventduration) {
                $('#calendar').fullCalendar('unselect');
                App.helpers.alert.info('Maximum duration exceeded', 'Max duration of reservation can be ' + maxeventduration + ' hours.');
                return false;
            }
            return true;
        }
        function reRenderCallendar() {
            $('#calendar-loader').removeClass('hidden');
            // $('#calendar').addClass('hidden');
            $('#calendar').fullCalendar('removeEvents');
            $('#calendar').fullCalendar('refetchEvents');
            setTimeout(function () {
                $('#calendar-loader').addClass('hidden');
                // $('#calendar').removeClass('hidden');
            },1000);
        }


        function update(event, revertFunc) {
            $("#updateReservationForm").attr("action", "{{ route('reservation.index') }}/" + event.id);
            $('#u_from_date').val(event.start.format('DD.MM.YYYY HH:mm:00'));
            $('#u_to_date').val(event.end.format('DD.MM.YYYY HH:mm:00'));
            $('#u_visitors_count').val(event.visitors_count);
            $('#u_note').val(event.note);
            $('#u_location_id').val(event.location_id);
        }



        function updateEvent(event, revertFunc) {
            var start = event.start;
            var end   = event.end;

            var correct = controlEventTimes(start, end);
            if (!correct) {
                revertFunc();
                return;
            }
            update(event);
            $("#updateReservationBtn").click()
        }


        function saveReservation() {

            $('#saveReservation').unbind();
            $('#saveReservation').bind('click', function (ev) {

                var valid = true;
                if ($('#from_date').val() == '') {
                    App.helpers.alert.info(App.trans('not-filled'), App.trans('fill-start-date'), 'danger');
                    valid = false;
                }
                else if ($('#to_date').val() == '') {
                    App.helpers.alert.info(App.trans('not-filled'), App.trans('fill-to-date'), 'danger');
                    valid = false;
                }
                if (!valid) {
                    ev.preventDefault();
                    return;
                }


            });
        }

        function initCalendar() {
            var canCreate=  {{Auth::check() && !Auth::user()->banned ? 'true' : 'false' }};
            var calendar = $('#calendar').fullCalendar({
                header         : {
                    left  : 'prev,next',
                    center: 'title',
                    right : ''
                },
                views          : {
                    agendaWeek: {
                        slotDuration: '00:15:00'
                    }
                },
                firstDay       : 1,
                nowIndicator   : true,
                allDaySlot     : false,
                timeFormat     : 'H:mm',
                slotLabelFormat: "H:mm",
                columnFormat   : 'ddd D.M.',
                locale         : '{{Session::get('lang') == 'cz' ? 'cs' : Session::get('lang') }}',
                titleFormat    : 'D. MMMM YYYY',
                defaultDate    : moment(new Date()).format('YYYY-MM-DD'),
                defaultView    : 'agendaWeek',
                editable       : canCreate,
                displayEventTime: true,
                eventRender: function (event, element, view) {
                    if (event.allDay === 'true') {
                        event.allDay = true;
                    } else {
                        event.allDay = false;
                    }
                },
                selectable: canCreate,
                selectHelper: true,
                select         : function (start, end) {

                    var correct = controlEventTimes(start, end);
                    if (!correct) {
                        return;
                    }

                    var now               = moment();
                    var future_date_today = moment(now).add(durationforedit, 'm');
                    var future_date       = moment(now).add(reservationarea, 'days');

                    if (start.isAfter(future_date_today.format('YYYY-MM-DD HH:mm')) && end.isBefore(future_date.format('YYYY-MM-DD'))) {
                        createEvent(start, end);
                    }
                    else {
                        $('#calendar').fullCalendar('unselect');
                        App.helpers.alert.info("You cannot reserve here", "This date/time is not opened for reservations.");
                    }
                },
                eventLimit     : true, // allow "more" link when too many events
                eventOverlap   : false,
                eventSources   : [
                    {
                        url   : '{{ route('getReservations') }}',
                        type   : 'POST',
                        data   : function () { // a function that returns an object
                            return {
                                location: $('[name="location"]:checked').val()
                            };
                        },
                        error  : function () {
                            App.helpers.alert.info(App.trans('modalProblemOnServer.title'), App.trans('modalProblemOnServer.text'));
                        },
                        overlap: false
                    }
                ],
                eventClick     : function (event) {
                    $('#showReservationModal').modal('show');
                    $('#showReservationModal').on('shown.bs.modal', function (e) {
                        $('#showReservationModalLabel').text(event.title);
                        $('#start').text(event.start.format("DD.MM.YYYY HH:mm"));
                        $('#end').text(event.end.format("DD.MM.YYYY HH:mm"));

                        if (event.editable) {
                            $('#deleteReservation').removeClass('hidden');
                            $("#deleteReservationForm").attr("action", "{{ route('reservation.index') }}/" + event.id);
                            $('#deleteReservation').unbind();
                            $('#deleteReservation').bind('click', function (ev) {
                                ev.preventDefault();
                                App.helpers.alert.confirm(App.trans('sure-delete'), App.trans('sure-delete-text'), 'warning', function () {
                                    $("#deleteReservationForm").submit();
                                })
                            });

                            //TODO ADD CHECK IF SHOULD BE EDITABLE, is in past, etc
                            $('#updateReservation').removeClass('hidden');
                            $('#updateReservation').unbind();
                            $('#updateReservation').bind('click', function (ev) {
                                update(event, null);
                                $('#updateReservationModal').modal('show');
                            });
                        }
                    });
                    return true;
                },
                eventResize    : function (event, delta, revertFunc) {
                    updateEvent(event, revertFunc);
                },
                eventDrop      : function (event, delta, revertFunc) {
                    updateEvent(event, revertFunc);
                },
                eventAllow     : function (dropLocation, draggedEvent) {
                    var now               = moment();
                    var future_date_today = moment(now).add(durationforedit, 'm');
                    var future_date       = moment(now).add(reservationarea, 'days');

                    //gmt fix
                    var dropStart = dropLocation.start;
                    dropStart     = dropStart.subtract(2, 'h');

                    return dropStart.isAfter(future_date_today.format('YYYY-MM-DD HH:mm')) && dropStart.isBefore(future_date.format('YYYY-MM-DD'));
                }
            });

            $('.fc-button').addClass('btn btn-primary').removeClass('fc-button').removeClass('fc-button fc-state-default');
            $('.fc-button-group').addClass('btn-group').removeClass('fc-button-group').attr('data-toggle', 'buttons');
        }

        function initOnChangeLocation() {
            $(document).on('change', '[name="location"]', function (ev) {
                $('#calendarContainer').css('visibility', 'visible');
                reRenderCallendar();
            });
        }

        function showCalenderIfOpened() {
            if($('[name="location"]:checked').size() > 0)
                $('#calendarContainer').css('visibility', 'visible');

        }
    </script>

@endpush
@include('admin.assets.datetimepicker')

@push('styles')
    <link href="{{asset('assets_client/datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('gentellela/vendors/fullcalendar/dist/fullcalendar.min.css')}}" rel="stylesheet">
    <link href="{{asset('gentellela/vendors/fullcalendar/dist/fullcalendar.print.css')}}" rel="stylesheet"
          media="print">
    <style>
        #calendar {
            max-width: 900px;
            margin: 0 auto;
        }
    </style>
@endpush
