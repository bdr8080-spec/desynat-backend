</main>


<!-- Vendor JS Files -->
<script src="{{ asset('dealer') }}/assets/custom-file/js/jquery.min.js"></script>
<script src="{{ asset('dealer') }}/assets/custom-file/js/bootstrap.bundle.min.js"></script>
<!--Main JS File -->
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>

<script src="{{ asset('dealer') }}/assets/custom-file/js/main.js"></script>


<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- jQuery (required by Toastr) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script>
    document.querySelectorAll('.notapplyspace').forEach(function(input) {
        input.addEventListener('keydown', function(e) {
            if (e.key === ' ') {
                e.preventDefault();
            }
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        const restrictedInputs = document.querySelectorAll('.blockFirstTime');

        restrictedInputs.forEach(input => {
            input.addEventListener('keydown', function(e) {
                if (e.key === ' ' && this.value.length === 0) {
                    e.preventDefault();
                }
            });

            input.addEventListener('input', function() {
                if (this.value.startsWith(' ')) {
                    this.value = this.value.trimStart();
                }
            });
        });
    });






    new DataTable('#example');

    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if (session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    @if (session('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif

    @if (session('info'))
        toastr.info("{{ session('info') }}");
    @endif
</script>

</body>

</html>
