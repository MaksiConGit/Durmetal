<div class="col-lg-4 col-md-6">
    <div class="mt-3">
        <div class="modal fade" id="modalToggle" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalToggleLabel">{{ $title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        {{ $body }}
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">
                            {{ $primary_text }}
                        </button>
                        <a href="" class="btn btn-danger" data-bs-dismiss="modal">
                            {{ $secondary_text }}
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
