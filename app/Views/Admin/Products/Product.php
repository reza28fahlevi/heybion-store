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
              <h5 class="card-title">Data Products</h5>
              <button type="button" class="btn btn-primary mb-3 btn-add" data-bs-toggle="modal" data-bs-target="#product-modal">
                <i class="bi bi-plus me-1"></i> Add
              </button>
              <!-- Table with stripped rows -->
              <table class="table" id="products-table">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Thumbnail</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Stock</th>
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

<?= $this->include('Admin/Products/Product_modal') ?>
<?= $this->include('Admin/Layout/Footer') ?>

<script>
  $(document).ready(function() {
      var tableProduct = $('#products-table').DataTable({
          "processing": true,
          "serverSide": true,
          "ajax": {
            "url" : "<?= base_url('hb-admin/products/fetch') ?>",
            "type" : "POST"
          },
          "columns": [
              { "data": "product_id" },
              { "data": "thumbnail", "render": function(data, type, row){
                return `<img src="<?= site_url('uploads/thumbnails/')?>${data}" alt="${row.product_name}" class="img-thumbnail" style="max-width:5rem; max-height:5rem;">`;
              } },
              { "data": "product_name" },
              { "data": "price_tag" },
              { "data": "stock" },
              { "data": "product_status", "render": function(data, type, row){
                if (data == 1){
                  return `<span class="badge rounded-pill bg-primary">Available</span>`;
                } else if (data == 2){
                  return `<span class="badge rounded-pill bg-secondary">Unavailable</span>`;
                } else {
                  return `<span class="badge rounded-pill bg-info">Pre Order</span>`;
                }
              } },
              { "data": null, "render": function(data, type, row) {
                  return `<button type="button" class="btn btn-success add-image" data-id="${row.product_id}"><i class="bi bi-card-image"></i></button>
                          <button type="button" class="btn btn-secondary edit-product" data-id="${row.product_id}"><i class="bi bi-pencil-square"></i></button>
                          <button type="button" class="btn btn-danger delete-product" data-id="${row.product_id}"><i class="bi bi-trash2"></i></button>`;
              }}
          ]
      });

      $('#f_product').on('submit', function(e) {
          e.preventDefault(); // Prevent the default form submission

          var act = $('#action').val()
          var id = $('#product_id').val()
          if(act == 'add' && id == ""){
            var link_url = '<?= site_url('hb-admin/products/add') ?>'
          }else if(act == 'update' && id != ""){
            var link_url = '<?= site_url('hb-admin/products/update') ?>'
          }else{
            var link_url = ""
          }

          $.ajax({
              url: link_url,
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

                  $('#product-modal').modal('hide')
                  tableProduct.ajax.reload(null, false);
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
      });

      $(document).on('click', '.btn-add', function() {
        $('#f_product').trigger('reset');
        $('#product_id').val("")
        $('#action').val("add")
        $('.input-thumbnail').show()
        $('.preview-thumbnail').hide()

        $('#thumbnail').attr('required', 'required');
      })

      $(document).on('click', '.add-image', function() {
          var id = $(this).data('id')
          window.open('<?= site_url('hb-admin/products/gallery/'); ?>' + id, '_blank');
      })

      $(document).on('click', '.edit-product', function() {
          var id = $(this).data('id')
          $.ajax({
            url: '<?= site_url('hb-admin/products/getData'); ?>/' + id,
            type: 'GET',
            success: function(response) {
                if (response.status === 'success') {
                    $('#f_product').trigger('reset');
                    $('#action').val("update")
                    $('#product_id').val(response.data.product_id);
                    $('#product_name').val(response.data.product_name);
                    $('#price_tag').val(response.data.price_tag);
                    $('#stock').val(response.data.stock);
                    $('#min_purchase').val(response.data.min_purchase);
                    $('#max_purchase').val(response.data.max_purchase);
                    $('input[name="product_status"][value="' + response.data.product_status + '"]').prop('checked', true);
                    $('#description').val(response.data.description);

                    $('.input-thumbnail').hide()
                    $('.preview-thumbnail').show()

                    $('.image-container').html(`<img src="<?= site_url('uploads/thumbnails/')?>`+response.data.thumbnail+`" alt="`+response.data.product_name+`" class="img-thumbnail" style="max-width:5rem; max-height:5rem;"><span class="close-icon">&times;</span>`)

                    $('#thumbnail').removeAttr('required')
                    $('#product-modal').modal('show')
                } else {
                    alert(response.message);
                }
            }
        });
      })

      $(document).on('click', '.close-icon', function() {
        $('.input-thumbnail').show()
        $('.preview-thumbnail').hide()
        $('#thumbnail').attr('required', 'required');
        $(this).closest('.image-container').html(""); 
      })

      $(document).on('click', '.delete-product', function() {
          var id = $(this).data('id')
          Swal.fire({
              title: "Are you sure?",
              text: "You won't be able to revert this!",
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Yes, delete it!"
          }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
                    url: '<?= site_url('hb-admin/products/delete') ?>',
                    type: 'POST',
                    data: {
                        "id" : id
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
                        tableProduct.ajax.reload(null, false);
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