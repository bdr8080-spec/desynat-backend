<!-- resources/views/layouts/header.blade.php -->
<nav class="navbar navbar-expand navbar-light custom-topbar mb-0 static-top shadow fixed-top">
    <div class="left-section d-flex align-items-center">
        <img src="{{ asset('admin/image/combine_logo.svg') }}" class="header-logo" alt="Logo" />
    </div>

    <div class="header-divider"></div>

    <div class="right-section">
        <div class="language-dropdown" id="languageDropdown">
    <button class="lang-btn" id="langToggle">
      <i class="fas fa-globe"></i> EN
      <i class="fas fa-chevron-down"></i>
    </button>

    <ul class="dropdown-menu" id="langMenu">
      <li>
        <img src="https://flagcdn.com/w20/gb.png" alt="English Flag" />
        English
      </li>
      <li>
        <img src="https://flagcdn.com/w20/sa.png" alt="Arabic Flag" />
        Arabic
      </li>
    </ul>
  </div>


    </div>
</nav>

  <script>
    const langBtn = document.getElementById("langToggle");
    const dropdown = document.getElementById("languageDropdown");

    // Toggle dropdown on click
    langBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      dropdown.classList.toggle("active");
    });

    // Close dropdown on clicking outside
    document.addEventListener("click", (e) => {
      if (!dropdown.contains(e.target)) {
        dropdown.classList.remove("active");
      }
    });
  </script>