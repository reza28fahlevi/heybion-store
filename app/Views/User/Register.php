<?= $this->include('User/Layout/Header') ?>

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row mb-2">
            <div class="col-md-12">
                <h2 class="text-center"><u>Create New Account</u></h2>
            </div>
        </div>

        <form id="f_register" class="php-email-form" data-aos="fade-up" data-aos-delay="300">
          <div class="row gy-4 justify-content-center">

            <div class="col-md-6 mx-5">
              <input type="text" name="name" id="name" class="form-control" placeholder="Your Name" required="">
            </div>

            <div class="col-md-6 mx-5">
              <input type="text" name="username" id="username" class="form-control input-user" placeholder="Username" required="">
            </div>

            <div class="col-md-6 mx-5">
                <input type="email" class="form-control input-user" id="email" name="email" placeholder="Your Email" required="">
            </div>

            <div class="col-md-6 mx-5">
              <input type="password" class="form-control" name="password" id="password" minlength="8" placeholder="Password" required="">
              <div class="invalid-feedback"></div>
            </div>

            <div class="col-md-6 mx-5">
              <input type="password" class="form-control" name="repassword" id="repassword" minlength="8" placeholder="Re-enter Password" required="">
              <div class="invalid-feedback"></div>
            </div>

            <div class="col-md-6 mx-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="show-password" value="true" id="show-password">
                    <label class="form-check-label spassword" for="showPassword">Show Password</label>
                </div>
            </div>

            <div class="col-md-6 mx-5 text-center">
              <button type="submit" class="mb-2">Sign In</button>
              <p>Don't have an account? <a href="<?= site_url('register')?>">Resgister Here</a></p>
            </div>

          </div>
        </form><!-- End Contact Form -->

      </div>

    </section><!-- /Contact Section -->

<?= $this->include('User/Layout/Footer') ?>

<script>
    $(document).ready(function() {
        // $('#username').on('input', function() {
        //     $(this).val($(this).val().replace(/\s/g, ''));
        // });
        // $('#email').on('input', function() {
        //     $(this).val($(this).val().replace(/\s/g, ''));
        // });

        function checkExisting(fld, val)
        {
            $.ajax({
                url: '<?= site_url('check') ?>',
                type: 'POST',
                data: {
                    'field': fld,
                    'value': val
                },
                // processData: false, // Important: Prevent jQuery from automatically transforming the data into a query string
                // contentType: false, // Important: Set the content type to false to allow multipart form data
                success: function(response) {
                    // Handle the response here
                    if(response.status == 'error'){
                        Swal.fire({
                            title: "Unavailable",
                            text: response.message,
                            icon: "warning"
                        });
                    }
                    // $(this).focus()
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                    Swal.fire({
                        title: "Error",
                        text: "Can't perform this action! Something wrong.",
                        icon: "error"
                    });
                }
            }, false);
            // return false;
        }
        $('.input-user').on('change', function() {
            $(this).val($(this).val().replace(/\s/g, ''));
            var fld = $(this).attr('id')
            var val = $(this).val()
            checkExisting(fld, val)
        });

        $(document).on('change', '#show-password', function() {
            const passwordField = $('#password');
            const repasswordField = $('#repassword');
            if ($(this).is(':checked')) {
                passwordField.attr('type', 'text');
                repasswordField.attr('type', 'text');
            } else {
                passwordField.attr('type', 'password');
                repasswordField.attr('type', 'password');
            }
        });

        $('#navuser ul').hide()

        $('#password').on("keyup", function() {
            var pass = $('#password').val()
            if(pass.length < 8){
                $('#password').next('.invalid-feedback').html('Password at least 8 character')
                $('#password').next('.invalid-feedback').show()
            }else{
                $('#password').next('.invalid-feedback').hide()
            }
        })

        $('#repassword').on("keyup", function() {
            var pass = $('#password').val()
            var repass = $('#repassword').val()

            if(pass !== repass){
                $('#repassword').next('.invalid-feedback').html('Password does not match')
                $('#repassword').next('.invalid-feedback').show()
            }else{
                $('#repassword').next('.invalid-feedback').hide()
            }
        })

        $('#f_register').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission
            var uname = $('#username').val()
            var email = $('#email').val()

            $.ajax({
                url: '<?= site_url('register') ?>',
                type: 'POST',
                data: new FormData(this),
                processData: false, // Important: Prevent jQuery from automatically transforming the data into a query string
                contentType: false, // Important: Set the content type to false to allow multipart form data
                success: function(response) {
                    // Handle the response here
                    if(response.status == 'error'){
                        Swal.fire({
                            title: "Unavailable",
                            text: response.message,
                            icon: "warning"
                        });
                        if(response.focus){
                            $('#'+response.focus).focus()
                        }
                    }else{
                        let timerInterval;
                        Swal.fire({
                            title: "Login Success!",
                            html: "Create account successfully, You must login first",
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

                            window.location.href = '<?= site_url('/login') ?>';
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