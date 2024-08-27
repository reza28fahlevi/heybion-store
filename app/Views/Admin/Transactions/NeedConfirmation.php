<?= $this->include('Admin/Layout/Header') ?>
<style>
    .image-container {
        position: relative;
        display: inline-block;
    }
    .close-icon {
        position: absolute;
        top: -2px;
        right: 0px;
        background-color: white;
        border-radius: 50%;
        cursor: pointer;
    }
</style>
<div class="pagetitle">
      <h1><?= $menu ?></h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Confirm Order</h5>
              <!-- Table with stripped rows -->
              <table class="table" id="transactions-table">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Invoice Number</th>
                    <th>Receipt</th>
                    <th>Date Order</th>
                    <th>Total Invoice</th>
                    <th>Status Order</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
    </section>

<?= $this->include('Admin/Transactions/Invoice_modal') ?>
<?= $this->include('Admin/Transactions/Cancel_modal') ?>
<?= $this->include('Admin/Layout/Footer') ?>

<script>
  $(document).ready(function() {
      var tableTransactions = $('#transactions-table').DataTable({
          "processing": true,
          "serverSide": true,
          "ajax": {
            "url" : "<?= base_url('hb-admin/transactions/getlist/2') ?>",
            "type" : "POST"
          },
          "columns": [
              { "data": "transaction_id" },
              { "data": "invoice_number" },
              { "data": "username" },
              { "data": "date_order" },
              { "data": "total_invoice" },
              { "data": "payment_status", "render": function(data, type, row){
                if (data == 1){
                  return `<span class="badge rounded-pill bg-secondary"><i class="bi bi-clock-fill me-1"></i> Waiting for payment</span>`;
                } else if (data == 2){
                  return `<span class="badge rounded-pill bg-dark"><i class="bi bi-hourglass-split me-1"></i> Waiting for confirmation</span>`;
                } else if (data == 3){
                  return `<span class="badge rounded-pill bg-warning"><i class="bi bi-box-seam me-1"></i> Processed</span>`;
                } else if (data == 4){
                  return `<span class="badge rounded-pill bg-info"><i class="bi bi-truck me-1"></i> Shipping</span>`;
                } else if (data == 6){
                  return `<span class="badge rounded-pill bg-danger"><i class="bi bi-x-lg me-1"></i> Order Canceled</span>`;
                } else {
                  return `<span class="badge rounded-pill bg-success"><i class="bi bi-patch-check me-1"></i> Finished</span>`;
                }
              } },
              { "data": null, "render": function(data, type, row) {
                  return `<button type="button" class="btn btn-primary see-details" data-id="${row.transaction_id}" data-bs-toggle="modal" data-bs-target="#invoice-modal"><i class="bi bi-eye-fill"></i></button>`;
              }}
          ]
      });

      $(document).on('click', '.see-details', function() {
        $("#invoice-modal").modal('show')
        var id = $(this).data('id')
        $('#transaction_id').val(id)
        $('.btn-submit').html('Confirm <i class="bi bi-check-lg"></i>')
        $('.btn-cancel').remove()
        $('.modal-footer .btn-submit').before('<button type="button" class="btn btn-danger btn-cancel" data-id="'+id+'">Cancel <i class="bi bi-x-lg"></i> </button>')
        $('#act').val('confirm')

        $.ajax({
            url: '<?= site_url('hb-admin/transactions/getdetail/') ?>' + id,
            type: 'GET',
            success: function(response) {
                // console.log(response.data)
                // Handle the response here
                $('#invoice-title').html(response.data.invoice.invoice_number + ' - ' + response.data.invoice.badge_status)
                $('#list-products').html(response.data.listProducts)
                $('.img-payment-proof').html('<img src="<?= site_url('uploads/payment_bill/') ?>' + response.data.invoice.payment_proof + '" class="d-block mx-auto" style="max-height:400px !important; max-width:100% !important;" alt="...">')
                if(response.data.userDetail){
                  $('.address-shpping').html('<strong>Shipping Address :</strong> ' + response.data.userDetail.recipient_name + ' | 0' + response.data.userDetail.phone_number + '<br>' +response.data.userDetail.address + ', ' + response.data.userDetail.pos_code + ', ' + response.data.userDetail.city + ', ' + response.data.userDetail.province + ', ' + response.data.userDetail.country)
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

      $(document).on('click', '.btn-cancel', function() {
          Swal.fire({
            title: "Are you sure want to cancel this order?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, cancel order!"
          }).then((result) => {
            if (result.isConfirmed) {
              $('#ctid').val($(this).data('id'))
              $('#cancel_reason').val('')
              $('#cancel-modal').modal('show')
              $('#invoice-modal').modal('hide')
            }
          });
      })

      $('#f_cancel').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?= site_url('hb-admin/transactions/submit') ?>',
            type: 'POST',
            data: {
                'act': 'cancel',
                'transaction_id': $('#ctid').val(),
                'cancel_reason': $('#cancel_reason').val()
            },
            // processData: false, // Important: Prevent jQuery from automatically transforming the data into a query string
            // contentType: false, // Important: Set the content type to false to allow multipart form data
            success: function(response) {
                // Handle the response here
                Swal.fire({
                  title: capitalizeFirstLetter(response.status),
                  text: response.message,
                  icon: "success"
                });

                $('#cancel-modal').modal('hide')
                tableTransactions.ajax.reload(null, false);
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

      $('#f_invoice').on('submit', function(e) {
          e.preventDefault(); // Prevent the default form submission

          Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, finish the order!"
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                  url: '<?= site_url('hb-admin/transactions/submit') ?>',
                  type: 'POST',
                  data: new FormData(this),
                  processData: false, // Important: Prevent jQuery from automatically transforming the data into a query string
                  contentType: false, // Important: Set the content type to false to allow multipart form data
                  success: function(response) {
                      // Handle the response here
                      Swal.fire({
                        title: capitalizeFirstLetter(response.status),
                        text: response.message,
                        icon: "success"
                      });

                      $('#invoice-modal').modal('hide')
                      tableTransactions.ajax.reload(null, false);
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
      });
  });
</script>