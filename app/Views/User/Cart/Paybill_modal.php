<div class="modal fade" id="payment-modal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <form name="f_payment" id="f_payment" enctype="multipart/form-data" class="form-input">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-sm-12 address-detail">
                            <h4>Upload your proof of transfer!</h4>
                            <h4>Payment Method : </h4>
                            <h4>BCA Bank Transfer to 123123 Heybion Store</h4>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Upload Transfer Billing</label>
                        <div class="col-sm-10">
                        <input type="hidden" name="tid" id="tid" value="">
                        <input type="file" class="form-control" id="upload_bill" name="upload_bill" accept=".jpg, .jpeg, .png" value="" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-default">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>