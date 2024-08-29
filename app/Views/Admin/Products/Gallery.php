<?= $this->include('Admin/Layout/Header') ?>

<div class="pagetitle">
      <h1><?= $menu ?></h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><?= $product->product_name ?></h5>
              <button type="button" class="btn btn-primary mb-3 btn-add" data-bs-toggle="modal" data-bs-target="#product-gallery-modal">
                <i class="bi bi-plus me-1"></i> Add
              </button>
              <!-- Table with stripped rows -->
              <table class="table" id="images-table">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Image</th>
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

<?= $this->include('Admin/Products/Gallery_modal') ?>
<?= $this->include('Admin/Layout/Footer') ?>

<script>
  $(document).ready(function() {
      var tableProduct = $('#images-table').DataTable({
          "processing": true,
          "serverSide": true,
          "searching": false,
          "ordering":  false,
          "ajax": {
            "url" : "<?= base_url('hb-admin/products/fetchGallery') ?>",
            "data" : {
              "product_id" : $("#product_id").val()
            },
            "type" : "POST"
          },
          "columns": [
              { "data": "prp_id" },
              { "data": "path", "render": function(data, type, row){
                return `<img src="<?= site_url('uploads/images/')?>${data}" alt="${row.product_name}" class="img-thumbnail" style="max-width:7rem; max-height:7rem;">`;
              } },
              { "data": null, "render": function(data, type, row) {
                  return `<button type="button" class="btn btn-danger delete-image" data-id="${row.prp_id}"><i class="bi bi-trash2"></i></button>`;
              }}
          ]
      });

      $('#f_productGallery').on('submit', function(e) {
          e.preventDefault(); // Prevent the default form submission

          $.ajax({
              url: '<?= site_url('hb-admin/products/addGallery') ?>',
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
                  tableProduct.ajax.reload(null, false);
                  $('#product-gallery-modal').modal('hide')
                  $('#imagesProduct').val('')
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

      $(document).on('click', '.delete-image', function() {
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
                    url: '<?= site_url('hb-admin/products/deleteGallery') ?>',
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