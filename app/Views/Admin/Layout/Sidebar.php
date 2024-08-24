
  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link <?= ($menu !== "Dashboard") ? 'collapsed' : '' ?>" href="<?= site_url("hb-admin")?>">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link <?= ($menu !== "Transactions") ? 'collapsed' : '' ?>" data-bs-target="#transactions-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Transactions</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="transactions-nav" class="nav-content <?= ($menu !== "Transactions") ? 'collapse' : '' ?> " data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?=site_url('hb-admin/need_confirmation')?>" class="nav-link <?= (isset($submenu) && $submenu !== "Confirmation") ? 'collapsed' : '' ?>">
              <i class="bi bi-circle"></i><span>Need Confirmation</span>
            </a>
          </li>
          <li>
            <a href="<?=site_url('hb-admin/waiting_delivery')?>" class="nav-link <?= (isset($submenu) && $submenu !== "Delivery") ? 'collapsed' : '' ?>">
              <i class="bi bi-circle"></i><span>Waiting Delivery</span>
            </a>
          </li>
          <li>
            <a href="<?=site_url('hb-admin/all_transactions')?>" class="nav-link <?= (isset($submenu) && $submenu !== "All") ? 'collapsed' : '' ?>">
              <i class="bi bi-circle"></i><span>All Transactions</span>
            </a>
          </li>
        </ul>
      </li><!-- End Transactions Nav -->

      <li class="nav-item">
        <a class="nav-link <?= ($menu !== "Products") ? 'collapsed' : '' ?>" data-bs-target="#products-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Products</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="products-nav" class="nav-content <?= ($menu !== "Products") ? 'collapse' : '' ?>" data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?=site_url('hb-admin/products')?>" class="nav-link <?= ($menu !== "Products") ? 'collapsed' : '' ?>">
              <i class="bi bi-circle"></i><span>Product</span>
            </a>
          </li>
        </ul>
      </li><!-- End Products Nav -->

      <!-- <li class="nav-heading">Account</li>

      <li class="nav-item">
        <a class="nav-link <?= ($menu !== "AccSettings") ? 'collapsed' : '' ?>" href="<?=site_url('hb-admin/account_settings')?>">
          <i class="bi bi-gear"></i>
          <span>Account Settings</span>
        </a>
      </li>End Account Settings Account Nav -->

      <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="<?=site_url('hb-admin/sign_out')?>">
          <i class="bi bi-box-arrow-right"></i>
          <span>Sign Out</span>
        </a>
      </li>End Sign Out Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->