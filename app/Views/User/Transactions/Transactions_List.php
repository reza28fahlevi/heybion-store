<?= $this->include('User/Layout/Header') ?>

    <!-- Page Title -->
    <div class="page-title" data-aos="fade">
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li class="current">My Transaction</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->

    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <?php
        $totalprd = 0;
        foreach($mytransaction as $invoice){
            $totalprd = count($invoice->details);
        ?>        
        <div class="row gy-4 mx-5 my-2 justify-content-center transaction-<?= $invoice->transaction_id ?>">
          <div class="col-lg-2">
            <img src="<?= (isset($invoice->details[0]->thumbnail)) ? site_url('uploads/thumbnails/').$invoice->details[0]->thumbnail : site_url('uploads/thumbnails/') ?>" class="img-fluid img-thumbnail " alt="">
          </div>
          <div class="col-lg-7 content pricing">
            <h6><a href="<?= site_url('transactiondetail/') . $invoice->transaction_id ?>"><?= $invoice->invoice_number ?></a> <?= $invoice->badge_status ?></h6>
            <ul>
                <li class="address-detail mb-1"> <h4 class="recipient"> <?= (isset($invoice->details[0]->product_name)) ? $invoice->details[0]->product_name : "-" ?> </h4></li>
                <li class="address-detail mb-3"> <h4 class="recipient" style="font-size: 15px;"> <?= ($totalprd > 1) ? "+".($totalprd-1)." Another Product" : "" ?> </h4></li>
                <li class="pricing-item"><i class="bi bi-chevron-right"></i> <strong>Total:</strong> <h4>Rp. <label class="item-pricing price-tag-<?= $invoice->transaction_id ?>"><?= $invoice->total_invoice ?></label></h4></li>
            </ul>
          </div>
          <div class="col-lg-2">
            <button type="button" class="btn-default btn-details form-control" data-trd="<?= $invoice->transaction_id ?>"> <i class="bi bi-list"></i> Details</button><br>
            <?= $invoice->btnPay ?>
            <?= $invoice->btnFinish ?>
          </div>
        </div>
        <?php
        }
        ?>

      </div>

    <?= $this->include('User/Transactions/Transaction_modal') ?>

    </section><!-- /About Section -->

<?= $this->include('User/Cart/Paybill_modal') ?>
<?= $this->include('User/Layout/Footer') ?>

<script>
    $(document).ready(function() {
        $('.btn-paybill').on('click', function() {
            var tid = $(this).data('trd')
            $("#tid").val(tid)
            $("#payment-modal").modal('show')
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
                    if(response.error == "signin"){
                        window.location.href = '<?= site_url('login') ?>';
                    }else{
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

        $('.btn-details').on('click', function() {
            var id = $(this).data('trd')

            $.ajax({
                url: '<?= site_url('getDetailInvoice/') ?>' + id,
                type: 'GET',
                // processData: false, // Important: Prevent jQuery from automatically transforming the data into a query string
                // contentType: false, // Important: Set the content type to false to allow multipart form data
                success: function(response) {
                    // Handle the response here
                    $('.invoice-head').html(response.data.invoice.invoice_number + '  ' + response.data.invoice.badge_status)
                    $('.recipient-detail').html('<strong>Shipping Address :</strong> ' + response.data.userDetail.recipient_name + ' | ' + response.data.userDetail.phone_number + ' </h4>')
                    $('.recipient-address').html(response.data.userDetail.address + ', ' + response.data.userDetail.pos_code + ', ' + response.data.userDetail.city + ', ' + response.data.userDetail.province + ', ' + response.data.userDetail.country)
                    $('.products-list').html(response.data.listProducts)
                    $('.total-price').html('Rp. ' + response.data.invoice.total_invoice)
                    if(response.data.invoice.receipt_number){
                        $('.detail-shipping').parent().show()
                        $('.detail-shipping').html(response.data.invoice.delivery_service + ' - ' + response.data.invoice.receipt_number)
                    }else{
                        $('.detail-shipping').parent().hide()
                    }
                    // if(response.data.invoice.payment_status == 4){
                    //     $('.footer-transaction').append('<button type="button" class="btn btn-default btn-finish" data-trd="' + response.data.invoice.transaction_id + '">Finish Order</button>')
                    // }else{
                    //     $('.btn-finish').remove()
                    // }
                    $('#transaction-modal').modal('show')
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

        $('.btn-finish').on('click', function() {
            var id = $(this).data('trd')

            Swal.fire({
                title: 'Order Received',
                text: 'Are you sure you want to end this order? Make sure the package has been received',
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#8f160d",
                cancelButtonColor: "#3d3d3d",
                confirmButtonText: "Finish Order"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= site_url('finishorder') ?>',
                        type: 'POST',
                        data: {
                            'trd': id
                        },
                        success: function(response) {
                            // Handle the response here
                            if(response.error == "signin"){
                                window.location.href = '<?= site_url('login') ?>';
                            }else{
                                Swal.fire({
                                    title: 'Thank You',
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
                }
            });
        })
    });

</script>