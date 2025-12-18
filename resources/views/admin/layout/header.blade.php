<!-- resources/views/layouts/header.blade.php -->
<nav class="navbar navbar-expand navbar-light custom-topbar mb-0 static-top shadow fixed-top">
    <div class="left-section d-flex align-items-center">
        <img src="{{ asset('admin/image/logo.svg') }}" class="img-fluid" alt="Logo" />
    </div>

    <div class="header-divider"></div>

    <div class="right-section">


      <div class="dropdown">
         <div class="profile-trigger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="/admin/image/hightlights-1.svg" class="header-profile-img" id="profileToggle">
        </div>

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li>
                <div class="seller-profile">
                    <div class="p-grid1 d-flex gap-3 align-items-center">
                        <img src="/admin/image/hightlights-1.svg" alt="Profile" class="rounded-circle profile-img">
                        
                        @auth('admin')
                            <div>
                                <h6 class="mb-0">{{ auth('admin')->user()->full_name }}</h6>
                                <div class="h-email">{{ auth('admin')->user()->email }}</div>
                            </div>
                        @endauth

                        <!-- <a class="drop-profile" href="#">
                            View Profile
                        </a> -->
                    </div>
                </div>
            </li>

            <li>
                <hr class="dropdown-divider">
            </li>

            <li>
                <a class="dropdown-item d-flex align-items-center gap-3 logout-item" href="{{route('adminLogout')}}">
                    <img src="/admin/image/logout-profile.svg">
                    <span class="text-red">LogOut</span>
                </a>
            </li>
        </ul>
      </div>



        <!-- LANGUAGE DROPDOWN -->
        <div class="language-dropdown" id="languageDropdown">
            <button class="lang-btn">
                <i class="fas fa-globe"></i> EN
                <i class="fas fa-chevron-down"></i>
            </button>
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

<!-- <script>
  const toggle = document.getElementById("profileToggle");
  const dropdown = document.getElementById("profileDropdown");

  toggle.addEventListener("click", function (e) {
    e.stopPropagation();
    dropdown.classList.toggle("open");
  });

  document.addEventListener("click", function () {
    dropdown.classList.remove("open");
  });
</script> -->