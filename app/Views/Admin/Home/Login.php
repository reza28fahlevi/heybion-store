<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>HeyBion Store - Login</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.js"></script>
  <script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
  <!-- Favicons -->
  <link href="<?=site_url()?>assets/img/favicon.png" rel="icon">
  <link href="<?=site_url()?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?=site_url()?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?=site_url()?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?=site_url()?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?=site_url()?>assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="<?=site_url()?>assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="<?=site_url()?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?=site_url()?>assets/vendor/simple-datatables/style.css" rel="stylesheet">
  
  <!-- Sweet alert -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.2/css/dataTables.dataTables.css" />

  <!-- Template Main CSS File -->
  <link href="<?=site_url()?>assets/css/style.css" rel="stylesheet">

</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">HeyBion - Admin</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your username & password to login</p>
                  </div>

                  <form id="f_login" class="row g-3 needs-validation" novalidate>

                    <div class="col-12">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" id="username" required>
                        <div class="invalid-feedback">Please enter your username.</div>
                    </div>

                    <div class="col-12">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                        <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="show-password" value="true" id="show-password">
                        <label class="form-check-label" for="showPassword">Show Password</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                  </form>

                </div>
              </div>

              <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                Designed by <a href="http://delta-e.cloud/">Heybion Store</a>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
    
    <?= $this->include('Admin/Layout/Footer') ?>

<script>
    $(document).ready(function() {
        $(document).on('change', '#show-password', function() {
            const passwordField = $('#password');
            if ($(this).is(':checked')) {
                passwordField.attr('type', 'text');
            } else {
                passwordField.attr('type', 'password');
            }
        });

        $('#f_login').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: '<?= site_url('hb-admin/login') ?>',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        let timerInterval;
                        Swal.fire({
                            title: "Login Success!",
                            html: "Please Wait, You Will Be Redirected to the Dashboard Page",
                            timer: 2000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                                const timer = Swal.getPopup().querySelector("b");
                                timerInterval = setInterval(() => {
                                timer.textContent = `${Swal.getTimerLeft()}`;
                                }, 100);
                            },
                            willClose: () => {
                                clearInterval(timerInterval);
                            }
                        }).then((result) => {
                            /* Read more about handling dismissals below */
                            // if (result.dismiss === Swal.DismissReason.timer) {
                            //     console.log("I was closed by the timer");
                            // }

                            window.location.href = '<?= site_url('hb-admin/') ?>';
                        });
                    } else {
                        Swal.fire({
                          title: "Cannot Login",
                          text: response.message,
                          icon: "error"
                        });
                    }
                }
            });
        });
    });
</script>