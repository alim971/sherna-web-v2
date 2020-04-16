    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            }
        });

        var clickHandler = function(e) {

            var url = $(this).data('url');
            // alert(id);
            $.ajax({
                url: url,
                type: 'POST',
                data: {_method: 'DELETE'},
                dataType: 'html'
            })
                .done(function(){
                    location.reload();
                })
            e.preventDefault();
            e.stopImmediatePropagation();
            return false;
        };
        $('.delete').one('click', clickHandler);
    </script>
