<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Desynat</title>
    <link href="css/style.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="image/favicon.svg" />

    <link href="css/bootstrap.css" rel="stylesheet" />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
      rel="stylesheet"
    />
  </head>


  <body id="page-top">
    <div id="wrapper">
      <ul
        class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion customSidebar"
        id="accordionSidebar"
      >
        <li class="nav-item active">
          <a class="nav-link" href="index.html">
            <span><img src="image/dashboard.svg" /></span>
            Dashboard</a
          >
        </li>
        <li class="nav-item">
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
        <div id="content">
          <nav
            class="navbar navbar-expand navbar-light custom-topbar mb-4 static-top shadow"
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

          <div class="inner-content">
            <div class="container-fluid">
              <div class="row align-items-center">
                <div class="col-lg-6">
                  <h2 class="h2">Welcome to Dashboard</h2>
                </div>
                <div class="col-lg-6">
                  <div
                    class="filter-box d-flex align-items-center justify-content-end"
                  >
                    <div class="form-check form-check-inline">
                      <input
                        class="form-check-input"
                        type="radio"
                        name="radioDefault"
                        checked
                      />
                      <label class="form-check-label">Today</label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input
                        class="form-check-input"
                        type="radio"
                        name="radioDefault"
                      />
                      <label class="form-check-label">This Week</label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input
                        class="form-check-input"
                        type="radio"
                        name="radioDefault"
                      />
                      <label class="form-check-label">This Month</label>
                    </div>

                    <!-- <input type="date" class="custom-date-input" />
      <input type="date" class="custom-date-input" /> -->
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 col-12">
                  <div class="form-group mt-5 w-100">
                    <label for="from" class="form-label">From:</label>
                    <input type="date" id="from" class="form-control" />
                  </div>
                </div>
                <div class="col-lg-3 col-md-4 col-12">
                  <div class="form-group mt-5 w-100">
                    <label for="from" class="form-label">To:</label>
                    <input type="date" id="from" class="form-control" />
                  </div>
                </div>
                <div class="col-lg-3 col-md-4 col-12">
                  <div class="form-group mt-5 w-100">
                    <label for="from" class="form-label">Country Name</label>
                    <select
                      class="form-select form-select-lg"
                      aria-label="Large select example"
                    >
                      <option selected>Select Country</option>
                      <option value="1">country One</option>
                      <option value="2">country Two</option>
                      <option value="3">country Three</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2 col-lg-3 col-12 mt-5">
                  <div
                    class="d-dlex justify-content-end"
                    style="text-align: end"
                  >
                    <a
                      class="btn btn-dark customBtn w-100"
                      style="margin-top: 30px"
                     
                    >
                      <span>Export in Excel or PDF</span></a
                    >
                  </div>
                </div>
              </div>

              <div class="col-12">
                <hr />
              </div>

              <div class="row justify-content-center">
                <div class="col-xl-3 col-md-6 mb-4">
                  <div class="card border-radious-10 dashboard-pnl">
                    <div class="card-header">
                      <div class="total-revenue justify-content-center">
                        <h3>Order Stats</h3>
                      </div>
                    </div>

                    <div class="card-body">
                      <div
                        class="h5 mb-0 font-weight-bold text-gray-800 justify-content-center"
                      >
                        $215,000
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                  <div class="card border-radious-10 dashboard-pnl">
                    <div class="card-header">
                      <div class="total-revenue justify-content-center">
                        <h3>Order Stats</h3>
                      </div>
                    </div>

                    <div class="card-body">
                      <div
                        class="h5 mb-0 font-weight-bold text-gray-800 justify-content-center"
                      >
                        $215,000
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                  <div class="card border-radious-10 dashboard-pnl">
                    <div class="card-header">
                      <div class="total-revenue justify-content-center">
                        <h3>Order Stats</h3>
                      </div>
                    </div>

                    <div class="card-body">
                      <div
                        class="h5 mb-0 font-weight-bold text-gray-800 justify-content-center"
                      >
                        $215,000
                      </div>
                    </div>
                  </div>
                </div>

                <div class="page-wapper dashboard-pnl">
                  <div class="row">
                    <div class="col-lg-6 col-md-6">
                      <div class="card border-radious-10">
                        <div class="card-header">
                          <div class="total-revenue justify-content-center">
                            <h3>Order Stats</h3>
                          </div>
                          <div class="dolor-icon">
                            <span> $1234</span>
                          </div>
                        </div>

                        <div class="card-body">
                          <div class="row">
                            <div class="total-sale b-line text-center col-lg-4">
                              <p>Ongoing</p>
                              <h5>136</h5>
                            </div>
                            <div class="total-sale b-line text-center col-lg-4">
                              <p>Completed</p>
                              <h5>136</h5>
                            </div>
                            <div
                              class="total-sale b-line-2 text-center col-lg-4"
                            >
                              <p>Canceled</p>
                              <h5>36</h5>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-5">
                      <div class="card border-radious-10">
                        <div class="card-header">
                          <div class="total-revenue">
                            <h3>Order Stats</h3>
                          </div>
                          <div class="dolor-icon">
                            <span> $1234</span>
                          </div>
                        </div>

                        <div class="card-body">
                          <div class="row">
                            <div class="total-sale b-line text-center col-lg-4">
                              <p>Ongoing</p>
                              <h5>136</h5>
                            </div>
                            <div class="total-sale b-line text-center col-lg-4">
                              <p>Completed</p>
                              <h5>136</h5>
                            </div>
                            <div
                              class="total-sale b-line-2 text-center col-lg-4"
                            >
                              <p>Canceled</p>
                              <h5>36</h5>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- <footer class="containerfooter">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; I chronic</span>
                    <a class="scroll-to-top rounded" href="#page-top" style="color: #fff;">
                        <i class="fas fa-angle-up"></i>
                    </a>
                </div>
            </footer> -->
      </div>
    </div>

    <div
      class="modal fade"
      id="logoutModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button
              class="close"
              type="button"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            Select "Logout" below if you are ready to end your current session.
          </div>
          <div class="modal-footer">
            <button
              class="btn btn-secondary"
              type="button"
              data-dismiss="modal"
            >
              Cancel
            </button>
            <a class="btn btn-primary" href="login.html">Logout</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->

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
  </body>
</html>
