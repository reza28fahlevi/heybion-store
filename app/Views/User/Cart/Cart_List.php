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
                    <li class="address-detail mb-0">
                        <h4 class="havent-added" <?= ($address) ? 'style="display: none;"' : '' ?>>You have not added a shipping address</h4>
                    </li>
                    <li class="address-detail mb-0">
                        <h4 class="recipient"> <?= ($address) ? $address->recipient_name . ' | 0' . $address->phone_number : '' ?> </h4>
                    </li>
                    <li class="pricing-item mt-0">
                        <h4 class="address"> <?= ($address) ? $address->address . ', ' . $address->pos_code . ', ' . $address->city . ', ' . $address->province . ', ' . $address->country : '' ?> </h4>
                    </li>
                </ul>
            </div>

            <div class="col-lg-1">
                <button type="button" class="btn-default btn-address" data-bs-toggle="modal" data-bs-target="#address-modal"><i class="bi <?= ($address) ? "bi-pencil-fill" : "bi-plus-circle-fill" ?>"></i></button>
            </div>
        </div>

        <?php
        foreach ($mycart as $cart) {
        ?>

            <div class="row gy-4 mx-5 my-2 justify-content-center cart-listing cart-<?= $cart->cart_id ?>">
                <div class="col-lg-2">
                    <a href="<?= site_url('product/') . $cart->product_id ?>"><img src="<?= site_url('uploads/thumbnails/') . $cart->thumbnail ?>" class="img-fluid img-thumbnail " alt=""></a>
                </div>
                <div class="col-lg-7 content pricing">
                    <h6><a href="<?= site_url('product/') . $cart->product_id ?>"><?= $cart->product_name ?></a></h6>
                    <ul>
                        <li class="pricing-item"><i class="bi bi-chevron-right"></i> <strong>Price:</strong>
                            <h4>Rp. <label class="item-pricing price-tag-<?= $cart->product_id ?>"><?= ($cart->price_tag * $cart->qty) ?></label></h4>
                        </li>
                    </ul>
                    <div class="row adding contact">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary border-0 min-qty" type="button" data-pid="<?= $cart->product_id ?>">-</button>
                                    </div>
                                    <input type="text" id="qty<?= $cart->product_id ?>" name="qty" class="form-control align-center qty" data-pid="<?= $cart->product_id ?>" data-cart="<?= $cart->cart_id ?>" style="text-align: center;" value="<?= $cart->qty ?>" aria-describedby="basic-addon1">
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

        <?php
        if ($mycart) {
        ?>
            <div class="row gy-4 mx-5 my-2 justify-content-center cart-listing">
                <div class="col-lg-8 content pricing">
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Courier :</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="courier" id="courier" required>
                            </select>
                        </div>
                    </div>
                    <h6><strong>Total Bill:</strong></h6>
                    <ul>
                        <li class="pricing-item"><i class="bi bi-chevron-right"></i>
                            <h4>Rp. <label class="total-bill"></label></h4>
                        </li>
                        <li class="address-detail my-0">
                            <h4>Sorry :(</h4>
                        </li>
                        <li class="address-detail">
                            <h4>Payment method can only be via ATM transfer to BCA account 123123 Heybion Store</h4>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-2">
                    <button type="button" class="btn-default btn-checkout">Pay Bill <i class="bi bi-credit-card-fill"></i></button>
                </div>
            </div>
        <?php } ?>

    </div>

</section><!-- /About Section -->

<?= $this->include('User/Cart/Address_modal') ?>
<?= $this->include('User/Cart/Paybill_modal') ?>
<?= $this->include('User/Layout/Footer') ?>

<script>
    function getProvince() {
        $("#province").empty()
        $("#province").append('<option value="">Pilih Province</option>')
        $.ajax({
            url: '<?= site_url('getProvince'); ?>',
            type: 'GET',
            data: {},
            success: function(response) {
                if (response.status === 'success') {
                    for (var i = 0; i < response.data.length; i++) {
                        $("#province").append($('<option>', {
                            value: response.data[i]["province_id"],
                            text: response.data[i]['province']
                        }));
                    }
                } else {
                    alert(response.message);
                }
            }
        })
    }

    getProvince()

    function getCity(province) {
        console.log(province)
        $("#city").empty()
        $("#city").append('<option value="">Pilih City</option>')
        $.ajax({
            url: '<?= site_url('getCity'); ?>',
            type: 'POST',
            data: {
                'province': province
            },
            success: function(response) {
                if (response.status === 'success') {
                    for (var i = 0; i < response.data.length; i++) {
                        $("#city").append('<option value="' + response.data[i]["city_id"] + '" data-poscode="' + response.data[i]["postal_code"] + '">' + response.data[i]["city_name"] + '</option>');
                    }
                } else {
                    alert(response.message);
                }
            }
        })
    }
    $('#province').on('change', function() {
        $("#city").empty()
        getCity($('#province').val())
    })

    $('#city').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var poscode = selectedOption.data('poscode');
        $('#pos_code').val('')
        $('#pos_code').val(poscode)
    })

    function getCost() {
        $("#courier").prop('disabled', true)
        $("#courier").empty()
        $("#courier").append('<option value="">Choose Expedition</option>')
        $.ajax({
            url: '<?= site_url('getCost'); ?>',
            type: 'GET',
            data: {},
            success: function(response) {
                // console.log(response.data[0]["costs"][0]["service"])
                // console.log(response.data[0]["costs"][0]["cost"][0]["value"])
                if (response.status === 'success') {
                    $("#courier").prop('disabled', false)
                    for (var i = 0; i < response.data.length; i++) {
                        for (var j = 0; j < response.data[i]["costs"].length; j++) {
                            $("#courier").append('<option value="' + response.data[i]["costs"][j]["service"] + '" data-harga="' + response.data[i]["costs"][j]["cost"][0]["value"] + '">' + response.data[i]["costs"][j]["description"] + ' | Etd ' + response.data[i]["costs"][j]["cost"][0]["etd"] + ' days | Price ' + response.data[i]["costs"][j]["cost"][0]["value"] + '</option>');
                        }
                    }
                } else {
                    alert(response.message);
                }
            }
        })
    }
    getCost()
    $('#courier').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var harga = selectedOption.data('harga');
        totalbilling(harga)
    })

    function checkStock(pid) {
        var qty = $('#qty' + pid).val()
        var id = pid
        if (qty == "") {
            $('#qty' + pid).val(1)
            var qty = 1;
        }
        var cart = $('#qty' + pid).data('cart')

        $.ajax({
            url: '<?= site_url('updatecart'); ?>',
            type: 'POST',
            data: {
                'id': id,
                'qty': qty,
                'cart': cart
            },
            success: function(response) {
                if (response.status === 'success') {
                    if (eval(qty) > eval(response.data.stock)) {
                        $('.stock-' + pid).html(response.data.stock)
                        $('.stock-warning-' + pid).show()
                        $('.btn-checkout').prop('disabled', true)
                        $('.btn-checkout').addClass('disabled')
                    } else {
                        $('.btn-checkout').prop('disabled', false)
                        $('.stock-warning-' + pid).hide()
                        $('.btn-checkout').removeClass('disabled')
                    }
                    $('.price-tag-' + pid).html(eval(response.data.price_tag) * eval(qty))

                    var selectedOption = $('#courier').find('option:selected');
                    var harga = selectedOption.data('harga');

                    totalbilling(harga)
                } else {
                    alert(response.message);
                }
            }
        })
    }

    function totalbilling(courier) {
        console.log(courier)
        var totalPrice = 0;

        $('.item-pricing').each(function() {
            totalPrice += parseFloat($(this).text()); // Convert the text to a number and add it to totalPrice
        });
        if (courier == 0 || courier == "" || courier === undefined) {
            $('.total-bill').html(totalPrice)
        } else {
            $('.total-bill').html(totalPrice + courier)
        }
    }

    $(document).ready(function() {
        var selectedOption = $('#courier').find('option:selected');
        var harga = selectedOption.data('harga');

        totalbilling(harga)
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
            var qty = $('#qty' + pid).val()

            if ((qty - 1) < 1) {
                $('#qty' + pid).val(1)
            } else {
                $('#qty' + pid).val(qty - 1)
            }

            checkStock(pid)
        });

        // Optionally prevent non-numeric keystrokes
        $('.plus-qty').on('click', function() {
            var pid = $(this).data('pid')
            var qty = $('#qty' + pid).val()

            $('#qty' + pid).val(eval(qty) + 1)

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

                    if (response.error == "signin") {
                        window.location.href = '<?= site_url('login') ?>';
                    } else {
                        $('.cart-' + cid).remove()
                        var selectedOption = $('#courier').find('option:selected');
                        var harga = selectedOption.data('harga');

                        totalbilling(harga)
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

        function getAddress() {
            $.ajax({
                url: '<?= site_url('getaddress'); ?>',
                type: 'GET',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#f_address').trigger('reset');
                        if (response.return == 'update') {
                            $('#recipient_name').val(response.data.recipient_name);
                            $('#phone_number').val('0' + response.data.phone_number);
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
        }

        $('.btn-address').on('click', function() {
            getAddress()
        })

        $('#f_address').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission
            var form_data = new FormData();

            var recipient_name = $('#recipient_name').val()
            var phone_number = $('#phone_number').val()
            var address = $('#address').val()
            var pos_code = $('#pos_code').val()
            var id_city = $('#city').val()
            var id_province = $('#province').val()
            var city = $('#city').find('option:selected').text()
            var province = $('#province').find('option:selected').text()
            var country = $('#country').val()

            form_data.append('recipient_name', recipient_name)
            form_data.append('phone_number', phone_number)
            form_data.append('address', address)
            form_data.append('pos_code', pos_code)
            form_data.append('id_city', id_city)
            form_data.append('id_province', id_province)
            form_data.append('city', city)
            form_data.append('province', province)
            form_data.append('country', country)
            $.ajax({
                url: '<?= site_url('updateaddress') ?>',
                type: 'POST',
                // data: new FormData(this),
                data: form_data,
                processData: false, // Important: Prevent jQuery from automatically transforming the data into a query string
                contentType: false, // Important: Set the content type to false to allow multipart form data
                success: function(response) {
                    // Handle the response here
                    if (response.error == "signin") {
                        window.location.href = '<?= site_url('login') ?>';
                    } else {
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
            var ongkir = $('#courier').find('option:selected').data('harga');
            var form_data = new FormData();
            form_data.append('ongkir', ongkir);
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
                        data: form_data,
                        processData: false, // Important: Prevent jQuery from automatically transforming the data into a query string
                        contentType: false, // Important: Set the content type to false to allow multipart form data
                        success: function(response) {
                            // Handle the response here
                            if (response.error == "signin") {
                                window.location.href = '<?= site_url('login') ?>';
                            } else if (response.error == 'empty_address') {
                                Swal.fire({
                                    title: "Address Not Found",
                                    text: response.message,
                                    icon: "warning",
                                    showCancelButton: false,
                                    confirmButtonColor: "#8f160d",
                                    confirmButtonText: "Add Address"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        getAddress()
                                        $('#address-modal').modal('show')
                                    }
                                });
                            } else {
                                $('.cart-listing').remove()
                                Swal.fire({
                                    title: "Invoice bill created",
                                    text: "Please finish your payment!",
                                    icon: "success",
                                    showCancelButton: false,
                                    confirmButtonColor: "#8f160d",
                                    confirmButtonText: "Upload Payment!"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $("#tid").val(response.tid)
                                        $("#payment-modal").modal('show')
                                    }
                                });
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
                }
            });
        })

        $('#f_payment').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            $.ajax({
                url: '<?= site_url('paybill') ?>',
                type: 'POST',
                data: new FormData(this),
                processData: false, // Important: Prevent jQuery from automatically transforming the data into a query string
                contentType: false, // Important: Set the content type to false to allow multipart form data
                success: function(response) {
                    // Handle the response here
                    if (response.error == "signin") {
                        window.location.href = '<?= site_url('login') ?>';
                    } else {
                        Swal.fire({
                            title: capitalizeFirstLetter(response.status),
                            text: response.message,
                            icon: "success",
                            confirmButtonColor: "#8f160d",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '<?= site_url('mytransaction') ?>';
                            }
                        });

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
    });
</script>