</main>

<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- jQuery (required by Toastr) -->
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>

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