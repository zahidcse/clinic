<div class="modal fade" id="uploadConsentImageModal" tabindex="-1" data-bs-backdrop="static" role="dialog"
     aria-labelledby="tooltipmodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Consent</h4>
                <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="" id="update_consent_form" action="" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="tab">
                        <div class="row g-3">
                            <input type="text" name="title" class="form-control" id="basicInput" placeholder="Type something...">
                            <input class="form-control" name="image" type="file" id="formFileMultiple" multiple>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="pull-left">

                        </div>
                        <div class="text-end pull-right">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                            <button id="update_form" class="btn btn-primary update_note" type="submit"
                                    name="update_note">Update</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
