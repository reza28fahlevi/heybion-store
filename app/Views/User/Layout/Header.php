<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>HeyBion Store</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.js"></script>
  <script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
  <!-- Favicons -->
  <link href="<?=site_url()?>assets/img/favicon.png" rel="icon">
  <link href="<?=site_url()?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Cardo:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= site_url() ?>assets_user/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= site_url() ?>assets_user/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= site_url() ?>assets_user/vendor/aos/aos.css" rel="stylesheet">
  <link href="<?= site_url() ?>assets_user/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="<?= site_url() ?>assets_user/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  
  <!-- Sweet alert -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.2/css/dataTables.dataTables.css" />

  <!-- Main CSS File -->
  <link href="<?= site_url() ?>assets_user/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: PhotoFolio
  * Template URL: https://bootstrapmade.com/photofolio-bootstrap-photography-website-template/
  * Updated: Jun 29 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

      <a href="<?= site_url() ?>" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="<?= site_url() ?>assets_user/img/logo.png" alt=""> -->
        <h1 class="sitename">HeyBion</h1>
        <i class="bi bi-cart3"></i>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="<?= site_url() ?>" class="<?= ($menu == "Shop") ? 'active' : '' ?>"><i class="bi bi-bag mx-1"></i> Shop</a></li>
          <li><a href="<?= site_url('mycart') ?>" class="<?= ($menu == "Cart") ? 'active' : '' ?>"><i class="bi bi-lg bi-basket mx-1"></i> Cart</a></li>
          
          <li><a href="<?= site_url('mytransaction') ?>" class="<?= ($menu == "Transaction") ? 'active' : '' ?>"><i class="bi bi-list mx-1"></i> Transaction</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="header-social-links">
        <span><?= (session()->get('username')) ? session()->get('name') : "" ?></span></i>
          <?php
          if(session()->get('username')){
          ?>
          <span><a href="#" class="btn-logout"><i class="bi bi-box-arrow-left mx-1" data-toggle="tooltip" data-placement="left" title="Sign Out"></i></a></span>
          <?php
          }else{
            ?>
          <span><a href="<?= site_url('login') ?>" class="btn-login"><i class="bi bi-box-arrow-in-right mx-1"></i> Sign In</a></span>
          <?php
          }
          ?>
      </div>

    </div>
  </header>

  <main class="main">