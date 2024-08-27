<div class="modal fade" id="cancel-modal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <form name="f_cancel" id="f_cancel" enctype="multipart/form-data">
                <input type="hidden" class="form-control" id="ctid" name="ctid" value="" required>
                <div class="modal-header">
                    <h5 class="modal-title">Reciept Number</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Reason</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="cancel_reason" name="cancel_reason" maxlength="150" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close <i class="bi bi-x-lg"></i></button>
                    <button type="submit" class="btn btn-danger">Cancel Order <i class="bi bi-x-lg"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>