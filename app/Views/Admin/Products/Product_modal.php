<div class="modal fade" id="product-modal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <form name="f_product" id="f_product">
                <div class="modal-header">
                    <h5 class="modal-title">Product Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Product Name</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="product_name" name="product_name">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputNumber" class="col-sm-2 col-form-label">Price</label>
                        <div class="col-sm-10">
                        <input type="number" class="form-control" id="price_tag" name="price_tag">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputNumber" class="col-sm-2 col-form-label">Stock</label>
                        <div class="col-sm-10">
                        <input type="number" class="form-control" id="stock" name="stock">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputNumber" class="col-sm-2 col-form-label">Min. Purchase</label>
                        <div class="col-sm-10">
                        <input type="number" class="form-control" id="min_purchase" name="min_purchase">
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
                        <div class="col-sm-10">
                        <input class="form-control" type="file" id="thumbnail">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputNumber" class="col-sm-2 col-form-label">Picture</label>
                        <div class="col-sm-10">
                        <input class="form-control" type="file" id="multiplePic" multiple>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" style="height: 100px" id="description" name="description"></textarea>
                        </div>
                    </div>
                    <fieldset class="row mb-3">
                        <legend class="col-form-label col-sm-2 pt-0">Product Status</legend>
                        <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="product_status" id="product_status1" value="1" checked>
                            <label class="form-check-label" for="product_status1">
                            Available
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="product_status" id="product_status2" value="2">
                            <label class="form-check-label" for="product_status2">
                            Unavailable
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="product_status" id="product_status3" value="3">
                            <label class="form-check-label" for="product_status3">
                            Pre Order
                            </label>
                        </div>
                        </div>
                    </fieldset>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>