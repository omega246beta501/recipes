<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog" id="{{ $modalId }}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="closeModalButton close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    {{ $slot }}
                </div>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="closeModalButton btn btn-secondary" data-dismiss="modal">Close</button>
            </div> -->
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.closeModalButton').click(function() {
            $('#{{ $modalId }}').modal('hide');
        });

        $("body").on("mousedown", function(e) {
            if($(e.target).attr('class') == 'modal fade show') {
                $('#{{ $modalId }}').modal('hide');
            }
        });
    });
</script>