<div>
    {{-- There's nothing here!!. --}}
</div>

@push('scripts')
<script>
    window.addEventListener('showMessage', event => {
        new Noty({
            text: event.detail.message,
            type: event.detail.type,
        }).show();

        // if (typeof event.detail.type != "undefined") {
        //     switch (event.detail.type) {
        //         case 'success':
        //             toastr.success(event.detail.message)
        //             break;
        //         case 'error':
        //             toastr.error(event.detail.message)
        //             break;
        //     }
        // }
    })

    // function alertSuccess(time_out, mess) {
    //     setTimeout(function () {
    //         toastr.options = {
    //             closeButton: false,
    //             progressBar: true,
    //             showMethod: 'slideDown',
    //             timeOut: time_out
    //         };
    //         toastr.success(mess, 'Thông báo');
    //     }, 500);
    // }

    // function alertError(time_out, mess) {
    //     setTimeout(function () {
    //         toastr.options = {
    //             closeButton: false,
    //             progressBar: true,
    //             showMethod: 'slideDown',
    //             timeOut: time_out
    //         };
    //         toastr.error(mess, 'Thông báo');
    //     }, 500);
    // }
</script>
@endpush
