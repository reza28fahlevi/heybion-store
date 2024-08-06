<div class="modal fade" id="product-modal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <form name="f_product" id="f_product" enctype="multipart/form-data">
                <input type="hidden" class="form-control" id="action" name="action" value="add" required>
                <input type="hidden" class="form-control" id="product_id" name="product_id" value="" required>
                <div class="modal-header">
                    <h5 class="modal-title">Product Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Product Name</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="product_name" name="product_name" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputNumber" class="col-sm-2 col-form-label">Price</label>
                        <div class="col-sm-10">
                        <input type="number" class="form-control" id="price_tag" name="price_tag" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputNumber" class="col-sm-2 col-form-label">Stock</label>
                        <div class="col-sm-10">
                        <input type="number" class="form-control" id="stock" name="stock" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputNumber" class="col-sm-2 col-form-label">Min. Purchase</label>
                        <div class="col-sm-10">
                        <input type="number" class="form-control" id="min_purchase" name="min_purchase" value="1" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputNumber" class="col-sm-2 col-form-label">Max. Purchase</label>
                        <div class="col-sm-10">
                        <input type="number" class="form-control" id="max_purchase" name="max_purchase">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputNumber" class="col-sm-2 col-form-label">Thumbnail</label>
                        <div class="col-sm-10 input-thumbnail">
                        <input class="form-control" type="file" id="thumbnail" name="thumbnail">
                        </div>
                        <div class="col-sm-10 preview-thumbnail">
                            <div class="image-container"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" style="height: 100px" id="description" name="description" required></textarea>
                        </div>
                    </div>
                    <fieldset class="row mb-3">
                        <legend class="col-form-label col-sm-2 pt-0">Product Status</legend>
                        <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="product_status" id="product_status1" value="1" checked>
                            <label class="form-check-label" for="product_status1">
                                <span class="badge rounded-pill bg-primary">Available</span>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="product_status" id="product_status2" value="2">
                            <label class="form-check-label" for="product_status2">
                                <span class="badge rounded-pill bg-secondary">Unavailable</span>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="product_status" id="product_status3" value="3">
                            <label class="form-check-label" for="product_status3">
                                <span class="badge rounded-pill bg-info">Pre Order</span>
                            </label>
                        </div>
                        </div>
                    </fieldset>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>