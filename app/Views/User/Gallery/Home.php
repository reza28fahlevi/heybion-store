<?= $this->include('User/Layout/Header') ?>

    <!-- Hero Section -->
    <section id="hero" class="hero section">

      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6 text-center" data-aos="fade-up" data-aos-delay="100">
            <h2><span class="underlight" style="color: #ffd700;">HeyBion Store</span> is officially online store for wearable suit</h2>
            <p>See our gallery products.</p>
          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- Gallery Section -->
    <section id="gallery" class="gallery section">

      <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4 justify-content-center">

            <?php
            foreach($products as $product){
                ?>
                <div class="col-xl-3 col-lg-4 col-md-6">
                  <a href="<?= site_url('product/').$product->product_id ?>" >
                    <div class="gallery-item h-100 ">
                    <img src="<?= site_url('uploads/thumbnails/') . $product->thumbnail ?>" class="img-fluid my-auto" alt="">
                    <div class="gallery-links d-flex align-items-center justify-content-center">
                        <div class="text-gallery text-center">
                          <span style="color: #f4f4f4"><?= $product->product_name . "<br>
                          Rp. " . $product->price_tag ?>
                          <?= ($product->product_status == 3) ? '<br> - Pre Order' : '' ?></span><br>
                        </div>
                    </div>
                  </div>
                  </a>
                </div><!-- End Gallery Item -->
                <?php
            }
            ?>

        </div>

      </div>

    </section><!-- /Gallery Section -->

<?= $this->include('User/Layout/Footer') ?>