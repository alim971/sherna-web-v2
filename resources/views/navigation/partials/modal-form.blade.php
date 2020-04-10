<div id="view-modal-{{$id}}" class="modal fade"
     tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close"
                        data-dismiss="modal"
                        aria-hidden="true">
                    ×
                </button>
                <h4 class="modal-title">
                    Podstranka
                </h4>
            </div>
            <div class="modal-body">

                <div id="modal-loader-{{$id}}"
                     style="display: none; text-align: center;">
                    <img src="{{asset('ajax-loader.gif')}}">
                </div>

                <!-- content will be load here -->
                <div id="dynamic-content-modal-{{$id}}"></div>

            </div>
            <div class="modal-footer">
                <button type="button"
                        class="btn btn-default"
                        data-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div><!-- /.modal -->

<button data-toggle="modal" data-target="#view-modal-{{$id}}"
        id="modal-{{$id}}" class="btn btn-sm btn-info"
        data-url="{{ $route }}">
    {{$btnText}}
</button>
@push('scripts')
    @include('navigation.partials.scripts.loader', ['id' => 'modal-' . $id])
@endpush

