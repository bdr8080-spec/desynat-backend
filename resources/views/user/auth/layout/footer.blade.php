   
   
   <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{asset('user/assets/js/jquery-3.7.1.min.js')}}" ></script>
    <script src="{{asset('user/assets/js/bootstrap.bundle.min.js')}}" ></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.0.3/js/intlTelInput.js"></script>
     <script src="{{asset('user/assets/js/custom.js')}}"></script>


     <script>

 
        document.querySelectorAll('.notapplyspace').forEach(function(input) {
            input.addEventListener('keydown', function(e) {
                if (e.key === ' ') {
                    e.preventDefault();
                }
            });
            });



    $("input, textarea, select").on("input", function() {
        var field = $(this).attr("name");
        $("#error-" + field).text("");
    });



    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    @if(session('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif

    @if(session('info'))
        toastr.info("{{ session('info') }}");
    @endif
</script>


</body>
</html>
