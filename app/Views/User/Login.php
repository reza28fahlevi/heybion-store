<?= $this->include('User/Layout/Header') ?>

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row mb-2">
            <div class="col-md-12">
                <h2 class="text-center"><u>Login</u></h2>
            </div>
        </div>

        <form id="f_login" class="php-email-form" data-aos="fade-up" data-aos-delay="300">
          <div class="row gy-4 justify-content-center">

            <div class="col-md-6 mx-5">
              <input type="text" name="username" id="username" class="form-control" placeholder="Username" required="">
            </div>

            <div class="col-md-6 mx-5">
              <input type="password" class="form-control" name="password" id="password" placeholder="Password" required="">
            </div>

            <div class="col-md-6 mx-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="show-password" value="true" id="show-password">
                    <label class="form-check-label spassword" for="showPassword">Show Password</label>
                </div>
            </div>

            <div class="col-md-6 mx-5 text-center">
              <button type="submit" class="mb-3">Sign In</button>
              <p>Don't have an account? <a href="<?= site_url('register')?>">Create new account</a></p>
            </div>

          </div>
        </form><!-- End Contact Form -->

      </div>

    </section><!-- /Contact Section -->

<?= $this->include('User/Layout/Footer') ?>

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

        $('#navuser ul').hide()

        $('#f_login').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: '<?= site_url('login') ?>',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        let timerInterval;
                        Swal.fire({
                            title: "Login Success!",
                            html: "Please Wait, You Will Be Redirected to the Store",
                            timer: 2000,
                            confirmButtonColor: "#8f160d",
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

                            window.location.href = '<?= site_url() ?>';
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