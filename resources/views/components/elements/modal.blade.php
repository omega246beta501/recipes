<div class="modal" data-bs-backdrop="static" tabindex="-1" role="dialog" id="{{ $modalId }}" xyz="fade out-delay-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content xyz-nested" xyz="fade short-100% delay-3 ease-out-back">
            <div class="modal-header xyz-nested" xyz="up-100% in-delay-3">
                <h5 class="modal-title xyz-nested" xyz="fade left in-delay-6">{{ $title }}</h5>
                <button type="button" class="closeModalButton close xyz-nested" data-dismiss="modal" aria-label="Close" xyz="fade small in-delay-7">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    {{ $slot }}
                </div>
            </div>
            <!-- <div class="modal-footer xyz-nested" xyz="down-100% in-delay-3">
                <button type="button" class="closeModalButton btn btn-secondary xyz-nested" xyz="fade in-right in-delay-7" data-dismiss="modal">Close</button>
            </div> -->
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.closeModalButton').click(function() {
            $('#{{ $modalId }}').removeClass('xyz-in');
            $('#{{ $modalId }}').addClass('xyz-out');
            //hide modal in 2 seconds
            setTimeout(function() {
                $('#{{ $modalId }}').modal('hide');
            }, 900);
        });

        $("body").on("mousedown", function(e) {
            if ($(e.target).attr('class') == 'modal show xyz-in') {
                $('#{{ $modalId }}').removeClass('xyz-in');
                $('#{{ $modalId }}').addClass('xyz-out');
                // $('#{{ $modalId }}').modal('hide');
                setTimeout(function() {
                    $('#{{ $modalId }}').modal('hide');
                }, 800);
            }
        });
    });
</script>