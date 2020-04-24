@push('scripts')
    <script>
        $(document).ready(function() {
            $("{{ $selector }}").autocomplete({

                source: function(request, response) {
                    $.ajax({
                        url: "{{ $url }}",
                        data: {
                            term : request.term
                        },
                        dataType: "json",
                        success: function(data){
                            var resp = $.map(data,function(obj){
                                return { label: obj.name, value: obj.id };
                            });

                            response(resp);
                        }
                    });
                },
                minLength: 1,
                select: function( event, ui ) {
                    $( "{{ $selector }}" ).val( ui.item.value );

                    return false;
                }
            })
        });

    </script>
@endpush
