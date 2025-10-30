<footer>
 <!-- Bootstrap core JavaScript-->

    <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/js/jquery.js') }}"></script>
    <script>
      $(document).ready(function () {
        $(".inner-content").removeClass("innerToggle");
        $(".menu").click(function () {
          $(".customSidebar").toggleClass("toggle");
          $(".inner-content").toggleClass("toggle");
        });
      });
    </script>
</footer>