<!-- resources/views/layouts/header.blade.php -->
<nav class="navbar navbar-expand navbar-light custom-topbar mb-0 static-top shadow fixed-top">
    <div class="left-section d-flex align-items-center">
        <img src="{{ asset('admin/image/logo.svg') }}" class="img-fluid" alt="Logo" />
    </div>

    <div class="header-divider"></div>

    <div class="right-section">
        @php
                $user = auth('admin')->user();
                $profileImage = !empty($user->profile_pic) 
                    ? $user->profile_pic 
                    : asset('/admin/image/hightlights-1.svg');
            @endphp

      <div class="dropdown">
         <div class="profile-trigger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{$profileImage}}" class="header-profile-img" id="profileToggle">
        </div>

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li>
                <div class="seller-profile">
                    <div class="p-grid1 d-flex gap-3 align-items-center">
                        <img src="{{$profileImage}}" alt="Profile" class="rounded-circle profile-img">
                        
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
        <div class="des-language">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle customBtn1" type="button"
                                    data-bs-toggle="dropdown">

                                    <img src="{{asset('user/assets/images/global.svg')}}" style="width:15px" />

                                    <span id="currentLang">EN</span>

                                </button>

                                <ul class="dropdown-menu dropdown-menu-end langu">

                                    <li>
                                        <a class="dropdown-item" data-lang="ar">
                                            <span>AR</span> Arabic
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" data-lang="en">
                                            <span>EN</span> English
                                        </a>
                                    </li>

                                </ul>
            </div>
        </div>

    </div>


</nav>

<div id="google_translate_element" style="display:none;"></div>
<div id="loaderTrans"
        style="display:none;
        position:fixed;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background:#ffffff; 
        z-index:999999;   
        /* display:flex;    */
        align-items:center;
        justify-content:center;">

        <iframe src="https://lottie.host/embed/7629c0ed-9538-4b83-b7ab-5870d7aae0ab/KLkQkV2bNW.lottie"
                style="border:none; width:200px; height:200px;">
        </iframe>
    </div>

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