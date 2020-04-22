@push('scripts')
    <script src="{{asset('gentellela/jquery.tagsinput.js')}}"></script>
    <script type="text/javascript">
        $('#tags').tagsInput({
            'autocomplete_url' : "{{ route('article.auto') }}",
            'height':'100px',
            'width':'100%',
            'interactive':true,
            'defaultText':'add a tag',
            'delimiter': ' ',   // Or a string with a single delimiter. Ex: ';'
            'removeWithBackspace' : true,
            'minChars' : 0,
            'maxChars' : 0, // if not provided there is no limit
            'placeholderColor' : '#666666'
        });
    </script>
@endpush
