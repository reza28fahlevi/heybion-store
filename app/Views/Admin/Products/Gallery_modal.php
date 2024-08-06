<div class="modal fade" id="product-gallery-modal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <form name="f_productGallery" id="f_productGallery" enctype="multipart/form-data">
                <input type="hidden" class="form-control" id="product_id" name="product_id" value="<?= $product->product_id ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Product Gallery</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Product Name</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="product_name" name="product_name" value="<?= $product->product_name ?>" disabled>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputNumber" class="col-sm-2 col-form-label">Photo</label>
                        <div class="col-sm-10">
                        <input class="form-control" type="file" id="imagesProduct" name="imagesProduct" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>