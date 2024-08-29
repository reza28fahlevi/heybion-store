
</main>

<footer id="footer" class="footer">

  <div class="container">
    <div class="copyright text-center ">
      <p>© <span>Copyright</span> <strong class="px-1 sitename"><i class="bi bi-triangle-fill"></i> E</strong> <span>All Rights Reserved</span></p>
    </div>
    <div class="credits">
      Designed by <a href="http://delta-e.cloud/">Heybion Store</a>.
    </div>
  </div>

</footer>

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Preloader -->
<!-- <div id="preloader">
  <div class="line"></div>
</div> -->

<!-- Vendor JS Files -->
<script src="<?= site_url() ?>assets_user/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= site_url() ?>assets_user/vendor/php-email-form/validate.js"></script>
<script src="<?= site_url() ?>assets_user/vendor/aos/aos.js"></script>
<script src="<?= site_url() ?>assets_user/vendor/glightbox/js/glightbox.min.js"></script>
<script src="<?= site_url() ?>assets_user/vendor/swiper/swiper-bundle.min.js"></script>

<!-- Main JS File -->
<script src="<?= site_url() ?>assets_user/js/main.js"></script>
<script>

  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
  function capitalizeFirstLetter(string) {
      if (!string) return string; // Handle empty strings
      return string.charAt(0).toUpperCase() + string.slice(1);
  }
  $(document).ready(function(){
    $('.btn-logout').on("click", function() {
      Swal.fire({
        title: "",
        text: "Are you sure want to sign out?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#8f160d",
        cancelButtonColor: "#3d3d3d",
        confirmButtonText: "Sign Out"
      }).then((result) => {
        if (result.isConfirmed){
          window.location.href = '<?= site_url('logout') ?>';
        }
      });
    })
  })
    
</script>
</body>

</html>