<div class="modal fade" id="invoice-modal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <form name="f_invoice" id="f_invoice" enctype="multipart/form-data">
                <input type="hidden" class="form-control" id="transaction_id" name="transaction_id" value="" required>
                <input type="hidden" class="form-control" id="act" name="act" value="" required>
                <div class="modal-header">
                    <h5 class="modal-title" id="invoice-title">Invoice Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                <!-- Bordered Tabs Justified -->
                <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
                    <li class="nav-item flex-fill" role="presentation">
                    <button class="nav-link w-100 active" id="product-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-products" type="button" role="tab" aria-controls="products" aria-selected="true">Product</button>
                    </li>
                    <li class="nav-item flex-fill" role="presentation">
                    <button class="nav-link w-100" id="address-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-address" type="button" role="tab" aria-controls="address" aria-selected="false" tabindex="-1">Address Shipping</button>
                    </li>
                    <li class="nav-item flex-fill" role="presentation">
                    <button class="nav-link w-100" id="payment-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-payment" type="button" role="tab" aria-controls="payment" aria-selected="false" tabindex="-1">Payment Proof</button>
                    </li>
                </ul>
                <div class="tab-content pt-2" id="borderedTabJustifiedContent">
                    <div class="tab-pane fade active show" id="bordered-justified-products" role="tabpanel" aria-labelledby="home-tab">
                        <h5 class="card-title">List Products</h5>

                        <!-- List group With badges -->
                        <ul class="list-group" id="list-products">
                        </ul><!-- End List With badges -->
                    </div>
                    <div class="tab-pane fade" id="bordered-justified-address" role="tabpanel" aria-labelledby="address-tab">
                        <p class="small fst-italic address-shpping">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p>
                    </div>
                    <div class="tab-pane fade img-payment-proof" id="bordered-justified-payment" role="tabpanel" aria-labelledby="payment-tab">
                        
                    </div>
                </div><!-- End Bordered Tabs Justified -->

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close <i class="bi bi-x-lg"></i> </button>
                    <button type="submit" class="btn btn-primary btn-submit"></button>
                </div>
            </form>
        </div>
    </div>
</div>