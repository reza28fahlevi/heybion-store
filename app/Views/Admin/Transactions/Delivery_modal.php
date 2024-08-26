<div class="modal fade" id="delivery-modal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <form name="f_delivery" id="f_delivery" enctype="multipart/form-data">
                <input type="hidden" class="form-control" id="tid" name="tid" value="" required>
                <div class="modal-header">
                    <h5 class="modal-title">Reciept Number</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Delivery Service</label>
                        <div class="col-sm-10">
                        <!-- <input type="text" class="form-control" id="delivery_service" name="delivery_service" placeholder="JNE/JNT/AnterAja/SiCepat" required> -->
                        <select name="delivery_service" id="delivery_service" class="form-control">
                            <option value="JNE">JNE</option>
                        </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Receipt Number</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="receipt_number" name="receipt_number" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close <i class="bi bi-x-lg"></i></button>
                    <button type="submit" class="btn btn-primary">Deliver <i class="bi bi-truck"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>