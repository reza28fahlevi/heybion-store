<?= $this->include('User/Layout/Header') ?>

    <!-- Page Title -->
    <div class="page-title" data-aos="fade">
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li class="current">My Cart</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->

    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4 mx-5 justify-content-center">
            <div class="col-lg-9 content pricing">
                <ul>
                    <li><strong>Shipping Address :</strong></li>
                    <li class="address-detail mb-0"> <h4 class="havent-added" <?= ($address) ? 'style="display: none;"' : '' ?>>You have not added a shipping address</h4></li>
                    <li class="address-detail mb-0"> <h4 class="recipient"> <?= ($address) ? $address->recipient_name.' | 0'.$address->phone_number : '' ?> </h4></li>
                    <li class="pricing-item mt-0"> <h4 class="address"> <?= ($address) ? $address->address.', '.$address->pos_code.', '.$address->city.', '.$address->province.', '.$address->country : '' ?> </h4></li>
                </ul>
            </div>

            <div class="col-lg-1">
                <button type="button" class="btn-default btn-address" data-bs-toggle="modal" data-bs-target="#address-modal"><i class="bi <?= ($address) ? "bi-pencil-fill" : "bi-plus-circle-fill" ?>"></i></button>
            </div>
        </div>

        <?php
        foreach($mycart as $cart){
        ?>
        
        <div class="row gy-4 mx-5 my-2 justify-content-center cart-<?= $cart->cart_id ?>">
          <div class="col-lg-2">
            <a href="<?= site_url('product/') . $cart->product_id ?>"><img src="<?= site_url('uploads/thumbnails/') . $cart->thumbnail ?>" class="img-fluid img-thumbnail " alt=""></a>
          </div>
          <div class="col-lg-7 content pricing">
            <h6><a href="<?= site_url('product/') . $cart->product_id ?>"><?= $cart->product_name ?></a></h6>
            <ul>
                <li class="pricing-item"><i class="bi bi-chevron-right"></i> <strong>Price:</strong> <h4>Rp. <label class="item-pricing price-tag-<?= $cart->product_id ?>"><?= ($cart->price_tag * $cart->qty) ?></label></h4></li>
            </ul>
            <div class="row adding contact">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary border-0 min-qty" type="button" data-pid="<?= $cart->product_id ?>">-</button>
                                </div>
                                <input type="text" id="qty<?= $cart->product_id ?>" name="qty" class="form-control align-center qty" data-pid="<?= $cart->product_id ?>" style="text-align: center;" value="<?= $cart->qty ?>" aria-describedby="basic-addon1">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary border-0 plus-qty" type="button" data-pid="<?= $cart->product_id ?>">+</button>
                                </div>
                            </div>
                            <span class="invalid-feedback stock-warning-<?= $cart->product_id ?> text-danger">Maksimal pembelian barang ini <label class="stock-<?= $cart->product_id ?>"></label> item, kurangi pembelianmu, ya!</span>
                        </div>
                    </div>
                <!-- </form> -->
            </div>
          </div>
          <div class="col-lg-1">
            <button type="button" class="btn-default btn-trash" data-cid="<?= $cart->cart_id ?>"> <i class="bi bi-trash-fill"></i></button>
          </div>
        </div>
        <?php
        }
        ?>

        <div class="row gy-4 mx-5 my-2 justify-content-center">
          <div class="col-lg-8 content pricing">
            <h6><strong>Total Bill:</strong></h6>
            <ul>
                <li class="pricing-item"><i class="bi bi-chevron-right"></i> <h4>Rp. <label class="total-bill"></label></h4></li>
                <li class="address-detail my-0"> <h4>Sorry :(</h4></li>
                <li class="address-detail"> <h4>Payment method can only be via ATM transfer to BCA account 123123 Heybion Store</h4></li>
            </ul>
          </div>
          <div class="col-lg-2">
            <button type="button" class="btn-default btn-checkout">Pay Bill <i class="bi bi-credit-card-fill"></i></button>
          </div>
        </div>

      </div>

    </section><!-- /About Section -->

<?= $this->include('User/Cart/Address_modal') ?>
<?= $this->include('User/Cart/Paybill_modal') ?>
<?= $this->include('User/Layout/Footer') ?>

<script>
    function checkStock(pid){
        var qty = $('#qty'+pid).val()
        var id = pid
        if(qty == ""){
            $('#qty'+pid).val(1)
        }
        
        $.ajax({
            url: '<?= site_url('getproduct'); ?>/' + id,
            type: 'GET',
            success: function(response) {
                if (response.status === 'success') {
                    if(eval(qty) > eval(response.data.stock)){
                        $('.stock-'+pid).html(response.data.stock)
                        $('.stock-warning-'+pid).show()
                    }else{
                        $('.stock-warning-'+pid).hide()
                    }
                    $('.price-tag-'+pid).html(eval(response.data.price_tag) * eval(qty))
                    totalbilling()
                } else {
                    alert(response.message);
                }
            }
        })
    }

    function totalbilling(){
        var totalPrice = 0;

        $('.item-pricing').each(function() {
            totalPrice += parseFloat($(this).text()); // Convert the text to a number and add it to totalPrice
        });

        $('.total-bill').html(totalPrice)
    }

    $(document).ready(function() {
        totalbilling()
        // Restrict input to numeric values only
        $('#phone_number').on('input', function() {
            // Replace any character that is not a digit
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        // Prevent pasting non-numeric content
        $('#phone_number').on('paste', function(e) {
            // Get the pasted data
            var pasteData = (e.originalEvent || e).clipboardData.getData('text');
            
            // If the pasted data is not numeric, prevent the paste
            if (!/^\d+$/.test(pasteData)) {
                e.preventDefault();
            }
        });
        // Optionally prevent non-numeric keystrokes
        $('#phone_number').on('keypress', function(e) {
            var keyCode = e.which ? e.which : e.keyCode;
            
            // Allow only numeric keys (0-9)
            if (keyCode < 48 || keyCode > 57) {
                e.preventDefault();
            }
        });

        // Restrict input to numeric values only
        $('#pos_code').on('input', function() {
            // Replace any character that is not a digit
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        // Prevent pasting non-numeric content
        $('#pos_code').on('paste', function(e) {
            // Get the pasted data
            var pasteData = (e.originalEvent || e).clipboardData.getData('text');
            
            // If the pasted data is not numeric, prevent the paste
            if (!/^\d+$/.test(pasteData)) {
                e.preventDefault();
            }
        });
        // Optionally prevent non-numeric keystrokes
        $('#pos_code').on('keypress', function(e) {
            var keyCode = e.which ? e.which : e.keyCode;
            
            // Allow only numeric keys (0-9)
            if (keyCode < 48 || keyCode > 57) {
                e.preventDefault();
            }
        });
        // Restrict input to numeric values only
        $('.qty').on('input', function() {
            var pid = $(this).data('pid')
            // Replace any character that is not a digit
            this.value = this.value.replace(/[^0-9]/g, '');
            checkStock(pid)
        });

        // Prevent pasting non-numeric content
        $('.qty').on('paste', function(e) {
            var pid = $(this).data('pid')
            // Get the pasted data
            var pasteData = (e.originalEvent || e).clipboardData.getData('text');
            
            // If the pasted data is not numeric, prevent the paste
            if (!/^\d+$/.test(pasteData)) {
                e.preventDefault();
            }
            checkStock(pid)
        });

        // Optionally prevent non-numeric keystrokes
        $('.qty').on('keypress', function(e) {
            var pid = $(this).data('pid')
            var keyCode = e.which ? e.which : e.keyCode;
            
            // Allow only numeric keys (0-9)
            if (keyCode < 48 || keyCode > 57) {
                e.preventDefault();
            }
            checkStock(pid)
        });

        // Optionally prevent non-numeric keystrokes
        $('.qty').on('change', function() {
            var pid = $(this).data('pid')
            checkStock(pid)
        });

        // Optionally prevent non-numeric keystrokes
        $('.min-qty').on('click', function() {
            var pid = $(this).data('pid')
            var qty = $('#qty'+pid).val()
            
            if((qty-1) < 1){
                $('#qty'+pid).val(1) 
            }else{
                $('#qty'+pid).val(qty - 1) 
            }
            
            checkStock(pid)
        });

        // Optionally prevent non-numeric keystrokes
        $('.plus-qty').on('click', function() {
            var pid = $(this).data('pid')
            var qty = $('#qty'+pid).val()
            
            $('#qty'+pid).val(eval(qty) + 1)

            checkStock(pid)
        });

        $('.btn-trash').on('click', function() {
            var cid = $(this).data('cid')
            $.ajax({
                url: '<?= site_url('removecart') ?>',
                type: 'POST',
                data: {
                    "id": cid,
                },
                // processData: false, // Important: Prevent jQuery from automatically transforming the data into a query string
                // contentType: false, // Important: Set the content type to false to allow multipart form data
                success: function(response) {
                    // Handle the response here

                    if(response.error == "signin"){
                        window.location.href = '<?= site_url('login') ?>';
                    }else{
                        $('.cart-'+cid).remove()
                        totalbilling()
                    }
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                    Swal.fire({
                        title: "Error",
                        text: "Can't perform this action! Something wrong.",
                        icon: "error"
                    });
                }
            });
        })

        $('.btn-address').on('click', function() {
            $.ajax({
                url: '<?= site_url('getaddress'); ?>',
                type: 'GET',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#f_address').trigger('reset');
                        if(response.return == 'update'){
                            $('#recipient_name').val(response.data.recipient_name);
                            $('#phone_number').val('0'+response.data.phone_number);
                            $('#address').val(response.data.address);
                            $('#pos_code').val(response.data.pos_code);
                            $('#city').val(response.data.city);
                            $('#province').val(response.data.province);
                            $('#country').val(response.data.country);
                        }
                    } else {
                        alert(response.message);
                    }
                }
            });
        })

        $('#f_address').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            $.ajax({
                url: '<?= site_url('updateaddress') ?>',
                type: 'POST',
                data: new FormData(this),
                processData: false, // Important: Prevent jQuery from automatically transforming the data into a query string
                contentType: false, // Important: Set the content type to false to allow multipart form data
                success: function(response) {
                    // Handle the response here
                    if(response.error == "signin"){
                        window.location.href = '<?= site_url('login') ?>';
                    }else{
                        Swal.fire({
                            title: capitalizeFirstLetter(response.status),
                            text: response.message,
                            icon: "success",
                            confirmButtonColor: "#8f160d",
                        });

                        $('#address-modal').modal('hide')
                    }
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                    Swal.fire({
                        title: "Error",
                        text: "Can't perform this action! Something wrong.",
                        icon: "error"
                    });
                }
            });
        })
        
        $('.btn-checkout').on('click', function() {
            Swal.fire({
                title: "Is the order is correct?",
                text: "You can't change the order later",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#8f160d",
                cancelButtonColor: "#d3d3d3",
                confirmButtonText: "Confirm"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= site_url('createinvoice') ?>',
                        type: 'POST',
                        // data: new FormData(this),
                        // processData: false, // Important: Prevent jQuery from automatically transforming the data into a query string
                        // contentType: false, // Important: Set the content type to false to allow multipart form data
                        success: function(response) {
                            // Handle the response here
                            
                            Swal.fire({
                                title: "Invoice bill created",
                                text: "Please finish your payment!",
                                icon: "success",
                                showCancelButton: false,
                                confirmButtonColor: "#8f160d",
                                confirmButtonText: "Upload Payment!"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#payment-modal").modal('show')
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            // Handle errors here
                            Swal.fire({
                                title: "Error",
                                text: "Can't perform this action! Something wrong.",
                                icon: "error"
                            });
                        }
                    });
                }
            });
        })
    });

</script>