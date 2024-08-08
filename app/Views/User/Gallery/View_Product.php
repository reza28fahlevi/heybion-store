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
          <div class="col-lg-5 content">
            <h2><?= $product->product_name ?></h2>
            <ul>
                <li><i class="bi bi-chevron-right"></i> <strong>Price:</strong> <span>Rp. <?= $product->price_tag ?></span></li>
            </ul>
            <p class="py-3">
            <?= $product->description ?>
            </p>
          </div>
        </div>

      </div>

    </section><!-- /About Section -->

<?= $this->include('User/Layout/Footer') ?>