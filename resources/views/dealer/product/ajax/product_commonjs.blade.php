<script>


// Remove 0 in women catgeory and other inout field

document.querySelectorAll('.no-zero').forEach(function(input) {

    // Remove leading zero(s)
    input.addEventListener('input', function () {
        if (this.value.startsWith('0')) {
            this.value = this.value.replace(/^0+/, '');
        }
    });

    // Prevent typing "0" as first character
    input.addEventListener('keydown', function (e) {
        if (e.key === '0' && this.selectionStart === 0) {
            e.preventDefault();
        }
    });

});

</script>