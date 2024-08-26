<?= $this->include('Admin/Layout/Header') ?>

    <div class="pagetitle">
      <h1>Dashboard</h1>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Sales Card -->
        <div class="col-xxl-3 col-md-6">
          <div class="card info-card sales-card">
            <div class="card-body">
              <h5 class="card-title">Sales <span>| This Month</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-cart"></i>
                </div>
                <div class="ps-3">
                  <h6><?= $sales->thisMonth?></h6>
                  <span class="text-<?= ($sales->percentageSales < 0) ? "danger" : "success"; ?> small pt-1 fw-bold"><?= $sales->percentageSales?>%</span> <span class="text-muted small pt-2 ps-1"><?= ($sales->percentageSales < 0) ? "decrease" : "increase"; ?></span>
                </div>
              </div>
            </div>

          </div>
        </div><!-- End Sales Card -->

        <!-- Customers Card -->
        <div class="col-xxl-3 col-md-6">

          <div class="card info-card customers-card">
            <div class="card-body">
              <h5 class="card-title">Customers <span>| This Month</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                  <h6><?= $sales->userThisMonth ?></h6>
                  <span class="text-<?= ($sales->percentageUser < 0) ? "danger" : "success"; ?> small pt-1 fw-bold"><?= $sales->percentageUser?>%</span> <span class="text-muted small pt-2 ps-1"><?= ($sales->percentageUser < 0) ? "decrease" : "increase"; ?></span>

                </div>
              </div>

            </div>
          </div>
        </div><!-- End Customers Card -->

        <!-- Invoice Card -->
        <div class="col-xxl-3 col-md-6">

          <div class="card info-card invoice-card">
            <div class="card-body">
              <h5 class="card-title">Invoice <span>| This Month</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-receipt"></i>
                </div>
                <div class="ps-3">
                  <h6><?= $sales->totalInvoice ?></h6>
                  <span class="text-<?= ($sales->percentageInvoice < 0) ? "danger" : "success"; ?> small pt-1 fw-bold"><?= $sales->percentageInvoice?>%</span> <span class="text-muted small pt-2 ps-1"><?= ($sales->percentageInvoice < 0) ? "decrease" : "increase"; ?></span>

                </div>
              </div>

            </div>
          </div>
        </div><!-- End Invoice Card -->
        
        <!-- Revenue Card -->
        <div class="col-xxl-3 col-md-6">
          <div class="card info-card revenue-card">
            <div class="card-body">
              <h5 class="card-title">Revenue <span>| This Month</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="ps-3">
                  <h6 style="font-size: 15px;"><?= rupiah($sales->totalRevenue) ?></h6>
                  <span class="text-<?= ($sales->percentageInvoice < 0) ? "danger" : "success"; ?> small pt-1 fw-bold"><?= $sales->percentageInvoice?>%</span> <span class="text-muted small pt-2 ps-1"><?= ($sales->percentageInvoice < 0) ? "decrease" : "increase"; ?></span>

                </div>
              </div>
            </div>

          </div>
        </div><!-- End Revenue Card -->
      </div>
      <div class="row">
        <div class="col-lg-7">
          <div class="row">
            <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">
                <div class="card-body">
                  <h5 class="card-title">Recent Sales <span></span></h5>

                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Product</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach($recentSales as $recent){
                        ?>
                        <tr>
                          <th scope="row"><?= $recent->invoice_number ?></th>
                          <td><a href="<?= site_url('product/') . $recent->product_id ?>" class="text-primary"><?= $recent->product_name ?></a></td>
                          <td><?= rupiah($recent->price_tag) ?></td>
                          <td><?= $recent->qty ?></td>
                          <td><?= badgeStatus($recent->payment_status) ?></td>
                        </tr>
                        <?php
                      }
                      ?>
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Recent Sales -->

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-5">

            <!-- Top Selling -->
            <div class="col-12">
              <div class="card top-selling overflow-auto">

                <div class="card-body pb-0">
                  <h5 class="card-title">Top Selling <span>| This Month</span></h5>

                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th scope="col">Preview</th>
                        <th scope="col">Product</th>
                        <th scope="col">Price Existing</th>
                        <th scope="col">Sold</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach($bestSeller as $prd){
                        ?>
                        <tr>
                          <th scope="row"><a href="#"><img src="<?=site_url('uploads/thumbnails/') . $prd->thumbnail ?>" alt="thumbnail-product"></a></th>
                          <td><a href="<?= site_url('product/') . $prd->product_id ?>" class="text-primary fw-bold" target="_blank"><?= $prd->product_name ?></a></td>
                          <td><?= rupiah($prd->price_tag) ?></td>
                          <td class="fw-bold"><?= $prd->total ?></td>
                        </tr>
                        <?php
                      }
                      ?>
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Top Selling -->

        </div><!-- End Right side columns -->

      </div>
    </section>

    <?= $this->include('Admin/Layout/Footer') ?>