<div id="view-modal" class="modal fade"
     tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">
                    {{$title}}
                </h4>
                <button type="button" class="close"
                        data-dismiss="modal"
                        aria-hidden="true">
                    ×
                </button>
            </div>
            <div class="modal-body">

                <div id="modal-loader"
                     style="display: none; text-align: center;">
                    <img src="{{asset('ajax-loader.gif')}}">
                </div>

                <!-- content will be load here -->
                <div class="dynamic-content"></div>

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


@push('scripts')
    @include('admin.assets.modal.scripts.loader')
@endpush

