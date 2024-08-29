<div class="modal fade" id="address-modal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <form name="f_address" id="f_address" enctype="multipart/form-data" class="form-input">
                <div class="modal-header">
                    <h5 class="modal-title">Add Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Recipient Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="recipient_name" name="recipient_name" value="" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Phone Number</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="phone_number" name="phone_number" value="" maxlength="15" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputNumber" class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-10">
                            <textarea name="address" id="address" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Province</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="province" id="province" required>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">City</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="city" id="city" required>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Pos Code</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="pos_code" name="pos_code" value="" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Country</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="country" name="country" value="" required>
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