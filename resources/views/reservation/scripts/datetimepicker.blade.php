<script type="text/javascript">
    $.fn.datetimepicker.dates['cz'] = {
        days: ["Neděle", "Pondělí", "Úterý", "Středa", "Čtvrtek", "Pátek", "Sobota", "Neděle"],
        daysShort: ["Ned", "Pon", "Úte", "Stř", "Čtv", "Pát", "Sob", "Ned"],
        daysMin: ["Ne", "Po", "Út", "St", "Čt", "Pá", "So", "Ne"],
        months: ["Leden", "Únor", "Březen", "Duben", "Květen", "Červen", "Červenec", "Srpen", "Září", "Říjen", "Listopad", "Prosinec"],
        monthsShort: ["Led", "Úno", "Bře", "Dub", "Kvě", "Čer", "Čnc", "Srp", "Zář", "Říj", "Lis", "Pro"],
        today: "Dnes",
        suffix: [],
        meridiem: [],
        weekStart: 1,
        format: "dd.mm.yyyy"
    };

    $(".form_datetime").datetimepicker({
        language: "{{$lang}}",
        format: "dd.mm.yyyy - hh:ii",
        autoclose: true,
        startDate: moment().add(15, "m").format("YYYY-MM-DD HH:mm"),
        endDate: moment().add(10, "d").format("YYYY-MM-DD HH:mm"),
        todayBtn: true,
        todayHighlight: false,
        bootcssVer: 3,
        pickerPosition: "bottom-left",
        minuteStep: 15
    });
</script>
