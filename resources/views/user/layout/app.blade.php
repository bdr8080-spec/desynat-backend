@include('user.layout.header')

<div class="mid-content">
@yield('content')
</div>

@include('user.layout.footer')


<script>
document.addEventListener("DOMContentLoaded", function () {
  function adjustProfileHeight() {
    const profile = document.querySelector(".mid-content");
    const footer = document.querySelector("footer");
    const header = document.querySelector("header");
    if (!profile) return;

    const footerHeight = footer ? footer.offsetHeight : 0;
    const headerHeight = header ? header.offsetHeight : 0;
    const windowHeight = window.innerHeight;
    const windowWidth = window.innerWidth;

    // ✅ Script sirf 1024px se zyada screens par chale
    if (windowWidth > 1024) {
      const availableHeight = windowHeight - (footerHeight + headerHeight + 50);
      profile.style.height = availableHeight + "px";
      profile.style.overflowY = "auto";
      profile.style.paddingBottom = "0";
    } else {
      // ❌ Mobile/tablet me disable
      profile.style.height = "auto";
      profile.style.overflowY = "visible";
      profile.style.paddingBottom = "0";
    }
  }

  // Run on load
  adjustProfileHeight();

  // Recalculate on resize/orientation change
  window.addEventListener("resize", adjustProfileHeight);
  window.addEventListener("orientationchange", adjustProfileHeight);

  // Observe footer height changes (only when active)
  const footer = document.querySelector("footer");
  if (footer) {
    const observer = new ResizeObserver(() => {
      if (window.innerWidth > 1024) adjustProfileHeight();
    });
    observer.observe(footer);
  }
});
</script>