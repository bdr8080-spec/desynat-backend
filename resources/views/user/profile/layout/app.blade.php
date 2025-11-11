@include('user.layout.header')

<div class="mid-content">
@yield('content')
</div>

@include('user.profile.layout.footer')


<script>
document.addEventListener("DOMContentLoaded", function () {
  function adjustProfileHeight() {
    const profile = document.querySelector(".mid-content");
    const footer = document.querySelector("footer"); // update if your footer has another selector
    const footerHeight = footer ? footer.offsetHeight : 80; // fallback if no footer
    const windowHeight = window.innerHeight;

    if (window.innerWidth <= 992) {
      // For smaller screens → make scrollable
      profile.style.height = `calc(${windowHeight}px - ${footerHeight + 20}px)`;
      profile.style.overflowY = "auto";
      profile.style.paddingBottom = `${footerHeight + 30}px`;
    } else {
      // For large screens → auto height
      profile.style.height = "auto";
      profile.style.overflowY = "visible";
      profile.style.paddingBottom = "19%";
    }
  }

  // Run on page load
  adjustProfileHeight();

  // Re-run when window resizes
  window.addEventListener("resize", adjustProfileHeight);
});
</script>