<?= $this->include('User/Layout/Header') ?>

    <!-- Page Title -->
    <div class="page-title" data-aos="fade">
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li class="current">About Product</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->

    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4 justify-content-center">
          <div class="col-lg-4">
            <img src="<?= site_url('uploads/thumbnails/') . $product->thumbnail ?>" class="img-fluid" alt="">
          </div>
          <div class="col-lg-5 content pricing">
            <h2><?= $product->product_name ?></h2>
            <ul>
                <li class="pricing-item"><i class="bi bi-chevron-right"></i> <strong>Price:</strong> <h4>Rp. <label class="price_tag"><?= $product->price_tag ?></label></h4></li>
            </ul>
            <p class="py-3">
            <?= $product->description ?>
            </p>
            <div class="row adding contact">
                <form id="add-cart" class="php-email-form aos-init aos-animate" data-aos="fade-up" data-aos-delay="300">
                    <input type="hidden" name="pid" id="pid" value="<?= $product->product_id ?>">
                    <div class="row">
                        <div class="col-lg-6 mb-2 pricing-item">
                            <h4>Rp. <label class="pricexqty"><?= $product->price_tag ?></label></h4>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <button id="min-qty" class="btn btn-outline-secondary border-0" type="button">-</button>
                                </div>
                                <input type="text" id="qty" name="qty" class="form-control align-center" style="text-align: center;" value="1" aria-describedby="basic-addon1">
                                <div class="input-group-append">
                                    <button id="plus-qty" class="btn btn-outline-secondary border-0" type="button">+</button>
                                </div>
                            </div>
                            <span class="text-secondary">Stock : <label class="stock"><?= $product->stock ?></label></span>
                            <span class="invalid-feedback stock-warning text-danger">Maksimal pembelian barang ini <label class="stock"><?= $product->stock ?></label> item, kurangi pembelianmu, ya!</span>
                        </div>
                    </div>
                    <button type="submit" class="btn-default btn-add-cart">ADD TO CART <i class="bi bi-cart3"></i></button>
                </form>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /About Section -->

    <?php
    if(count($gallery) > 0){
    ?>
    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Gallery</h2>
        <p>What you see what you get</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="swiper init-swiper">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 1,
                  "spaceBetween": 40
                },
                "1200": {
                  "slidesPerView": 3,
                  "spaceBetween": 1
                }
              }
            }
          </script>
          <div class="swiper-wrapper">

            <?php 
            foreach($gallery as $slide){
                ?>
                <div class="swiper-slide">
                <div class="testimonial-item">
                    <img src="<?= site_url('uploads/images/') . $slide->path ?>" class="img-fluid" alt="">
                </div>
                </div><!-- End testimonial item -->
                <?php
            }
            ?>

          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>

    </section><!-- /Testimonials Section -->

    <?php
    }
    ?>

<?= $this->include('User/Layout/Footer') ?>

<script>
    function checkStock(){
        var qty = $('#qty').val()
        var id = $('#pid').val()
        if(qty == ""){
            $('#qty').val(1)
        }
        
        $.ajax({
            url: '<?= site_url('getproduct'); ?>/' + id,
            type: 'GET',
            success: function(response) {
                if (response.status === 'success') {
                    if(eval(qty) > eval(response.data.stock)){
                        $('.stock-warning').show()
                        $('.btn-add-cart').prop('disabled',true)
                        $('.btn-add-cart').addClass('disabled')
                    }else{
                        $('.stock-warning').hide()
                        $('.btn-add-cart').prop('disabled',false)
                        $('.btn-add-cart').removeClass('disabled')
                    }
                    $('.price_tag').html(response.data.price_tag)
                    $('.stock').html(response.data.stock)
                    $('.pricexqty').html(eval(response.data.price_tag) * eval(qty))
                } else {
                    alert(response.message);
                }
            }
        })
    }

    $(document).ready(function() {
        // Restrict input to numeric values only
        $('#qty').on('input', function() {
            // Replace any character that is not a digit
            this.value = this.value.replace(/[^0-9]/g, '');
            checkStock()
        });

        // Prevent pasting non-numeric content
        $('#qty').on('paste', function(e) {
            // Get the pasted data
            var pasteData = (e.originalEvent || e).clipboardData.getData('text');
            
            // If the pasted data is not numeric, prevent the paste
            if (!/^\d+$/.test(pasteData)) {
                e.preventDefault();
            }
            checkStock()
        });

        // Optionally prevent non-numeric keystrokes
        $('#qty').on('keypress', function(e) {
            var keyCode = e.which ? e.which : e.keyCode;
            
            // Allow only numeric keys (0-9)
            if (keyCode < 48 || keyCode > 57) {
                e.preventDefault();
            }
            checkStock()
        });

        // Optionally prevent non-numeric keystrokes
        $('#qty').on('change', function() {
            checkStock()
        });

        // Optionally prevent non-numeric keystrokes
        $('#min-qty').on('click', function() {
            var qty = $('#qty').val()
            
            if((qty-1) < 1){
                $('#qty').val(1) 
            }else{
                $('#qty').val(qty - 1) 
            }
            checkStock()
        });

        // Optionally prevent non-numeric keystrokes
        $('#plus-qty').on('click', function() {
            var qty = $('#qty').val()
            
            $('#qty').val(eval(qty) + 1) 
            checkStock()
        });

        
        $('#add-cart').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            $.ajax({
                url: '<?= site_url('addcart') ?>',
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
        });

    });

</script>