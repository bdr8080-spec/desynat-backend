<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Desynat</title>
    <!-- <link href="css/style.css" rel="stylesheet" /> -->
    <link rel="icon" type="image/x-icon" href="image/favicon.svg" />
 <link href="{{asset('admin/css/style.css')}}" rel="stylesheet" />
    <link href="{{asset('admin/css/bootstrap.css')}}" rel="stylesheet" />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
      rel="stylesheet"
    />
    <link href="css/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <!-- <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet"> -->
  </head>

  <body id="page-top">
    <div id="wrapper">
      <ul
        class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion customSidebar"
        id="accordionSidebar"
      >
        <li class="nav-item ">
          <a class="nav-link" href="index.html">
            <span><img src="image/dashboard.svg" /></span>
            Dashboard</a
          >
        </li>

        <li class="nav-item active">
          <a class="nav-link" href="Brands.html">
            <span><img src="image/brand-icon.svg"></span>
            Brands Management</a
          >
        </li>
           <li class="nav-item">
          <a class="nav-link" href="category&subcategory-mgmt.html">
            <span><img src="image/brand-icon.svg"></span>
            Category & Sub-Cattegory Management</a
          >
        </li>
      </ul>
      <div id="content-wrapper" class="d-flex flex-column position-relative">
        <div id="content" class="">
          <nav
            class="navbar navbar-expand navbar-light custom-topbar mb-0 static-top shadow"
          >
            <div class="left-section d-flex align-items-center">
              <img src="image/combine_logo.svg" class="header-logo" />
            </div>

            <div class="header-divider"></div>

            <div class="right-section">
              <button class="lang-btn">
                <i class="fas fa-globe"></i> EN
                <i class="fas fa-chevron-down"></i>
              </button>
            </div>
          </nav>

          <div class="inner-content management">
            <div class="row align-items-center justify-content-between">
              <div class="col-lg-6 col-md-6 col-12">
                <h2 class="h2">Brands Management</h2>
              </div>

              <div class="col-lg-3 col-md-4 col-12">
                <div class="d-flex justify-content-end">
                  <a
                    class="btn btn-dark customBtn"
                    data-bs-toggle="modal"
                    data-bs-target="#sentModal2"
                  >
                    <span>Add New Brands</span>
                  </a>
                </div>
              </div>
            </div>

            <div class="userManagecontent">
              <div class="mt-4">
                <div class="align-items-end d-flex">
                  <div
                    class="search-box"
                    style="position: relative;"
                  >
                    <i
                      class="bi bi-search"
                      style="
                        position: absolute;
                        left: 10px;
                        top: 50%;
                        transform: translateY(-50%);
                        font-size: 16px;
                        color: #888;
                      "
                    >
                    </i>
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Search for..."
                      style="padding-left: 35px"
                    />
                  </div>
                </div>

                <div class="table-responsive w-100">
                  <table class="table w-100">
                    <thead>
                      <tr>
                        <th scope="col">SR No.</th>
                        <th scope="col">Image</th>
                        <th scope="col">Brand name</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">1</th>
                        <td>
                          <img
                            src="image/profile.jpg"
                            alt=""
                            width="40px"
                            height="40px"
                            class="square"
                          />
                        </td>
                        <td>Zenith</td>
                        <td>
                          <div class="d-flex gap-3 justify-content-center">
                            <a
                              class="table-button"
                              type="button"
                              data-bs-toggle="modal"
                              data-bs-target="#sentModal3"
                              ><i class="bi bi-pencil-square"></i
                            ></a>

                            <a class="table-button" type="button">
                              <i class="bi bi-trash3-fill"></i>
                            </a>

                            <div class="form-check form-switch">
                              <input
                                class="form-check-input"
                                type="checkbox"
                                role="switch"
                                id="flexSwitchCheckChecked"
                              />
                              <label
                                class="form-check-label"
                                for="flexSwitchCheckChecked"
                              ></label>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">1</th>
                        <td>
                          <img
                            src="image/profile.jpg"
                            alt=""
                            width="40px"
                            height="40px"
                            class="square"
                          />
                        </td>
                        <td>Rolex</td>
                        <td>
                          <div class="d-flex gap-3 justify-content-center">
                            <a
                              class="table-button"
                              type="button"
                              data-bs-toggle="modal"
                              data-bs-target="#sentModal3"
                              ><i class="bi bi-pencil-square"></i
                            ></a>

                            <a
                              class="table-button"
                              type="button"
                              id="delete_category"
                            >
                              <i class="bi bi-trash3-fill"></i>
                            </a>

                            <div class="form-check form-switch">
                              <input
                                class="form-check-input"
                                type="checkbox"
                                role="switch"
                                id="flexSwitchCheckChecked"
                              />
                              <label
                                class="form-check-label"
                                for="flexSwitchCheckChecked"
                              ></label>
                            </div>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- add new model -->
    <div
      class="modal fade"
      id="sentModal2"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header management border-0">
            <!-- <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1> -->
            <h2 class="h2">Add New Brands</h2>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="appointment-container">
              <form>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="upload-title text-center">
                      Upload profile image
                    </div>

                    <label for="fileUpload" class="upload-box">
                      <img
                        src="https://cdn-icons-png.flaticon.com/512/847/847969.png"
                        id="uploadIcon"
                      />
                      <img id="previewImage" class="preview-image" />
                      <div class="upload-text">Upload profile image</div>
                      <input
                        type="file"
                        id="fileUpload"
                        hidden
                        accept="image/*"
                      />
                    </label>
                  </div>

                  <div class="col-lg-12 col-md-12 col-12">
                    <div class="form-group">
                      <div class="form-group">
                        <label for="exampleFormControlInput1" class="form-label"
                          >Brand Name (English)</label
                        >
                        <input
                          type="text"
                          placeholder="Brand Name"
                          class="form-control"
                          aria-describedby="passwordHelpInline"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-12">
                    <div class="form-group">
                      <div class="form-group">
                        <label for="exampleFormControlInput1" class="form-label"
                          >Add Brand Name (Arabic)</label
                        >
                        <input
                          type="text"
                          placeholder="Brand Name"
                          class="form-control"
                          aria-describedby="passwordHelpInline"
                        />
                      </div>
                    </div>
                  </div>
                  <div
                    class="col-lg-12 col-md-12 col-12 d-flex justify-content-center"
                  >
                    <div
                      class="d-flex align-items-center justify-content-center gap-3 mt-3"
                      style="margin-top: 30px"
                    >
                      <a class="btn btn-dark customBtn" href=""> Submit</a>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.js"></script>
    <script>
      $(document).ready(function () {
        $(".inner-content").removeClass("innerToggle");
        $(".menu").click(function () {
          $(".customSidebar").toggleClass("toggle");
          $(".inner-content").toggleClass("toggle");
        });
      });
    </script>
    <script>
      const fileInput = document.getElementById("fileUpload");
      const previewImage = document.getElementById("previewImage");
      const uploadIcon = document.getElementById("uploadIcon");

      fileInput.addEventListener("change", function () {
        const file = this.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = function (e) {
            previewImage.src = e.target.result;
            previewImage.style.display = "block";
            uploadIcon.style.display = "none";
          };
          reader.readAsDataURL(file);
        }
      });
    </script>
  </body>
</html>
