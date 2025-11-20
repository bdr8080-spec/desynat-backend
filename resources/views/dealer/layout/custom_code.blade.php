</main>

<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- jQuery (required by Toastr) -->
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

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


    // remove Error Text message on input field
    $(document).ready(function() {
        // When user types in any input or textarea
        $(document).on('input', '.form-control, .form-check-input', function() {

            // Check if input has a value (not empty)
            if ($(this).val().trim() !== '') {
                // Remove the nearby error message
                // $(this).closest('.form-group').find('.text-danger').fadeOut(200, function() {
                //     $(this).remove();
                // });

                // // add to product remove Error message
                // $(this).closest('.sub-form').find('.text-danger').fadeOut(200, function() {
                //     $(this).remove();
                // });

                // $(this)
                //     .closest('.form-group')
                //     .find('.text-danger')
                //     .text('');

                // For dynamic product fields
                $(this)
                    .closest('.sub-form')
                    .find('.text-danger')
                    .text('');

            }
        });
    });
</script>

</body>

</html>
