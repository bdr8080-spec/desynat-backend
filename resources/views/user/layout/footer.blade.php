     <script src="{{asset('user/assets/js/custom.js')}}"></script>
    <script src="assets/js/bootstrap.bundle.min.js" ></script>
    <!-- <script src="assets/js/fontawesome.min.js" ></script> -->
    <script src="assets/js/custom.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#fileInput").change(function (e) {
                const file = e.target.files[0];
                if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    $("#profileImg").attr("src", event.target.result);
                };
                reader.readAsDataURL(file);
                }
            });
            });
    </script>

</body>
</html>