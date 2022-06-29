<div id="accordion">
    <div class="card">
        <div class="card-header" id="headingOne">
            <h5 class="mb-0">
                <button class="btn" id="{{ $accordionButtonId }}" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    {{ $buttonName }}
                </button>
            </h5>
        </div>

        <div id="{{ $accordionId }}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#{{ $accordionButtonId }}').click(function() {
            $('#{{ $accordionId }}').collapse('toggle');
        });
    });
</script>