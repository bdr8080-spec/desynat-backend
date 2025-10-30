@extends('admin.layout.app')
@section('content')
      <div id="content-wrapper" class="d-flex flex-column position-relative">
        <div id="content" class="">
          <nav
            class="navbar navbar-expand navbar-light custom-topbar mb-0 static-top shadow"
          >
            <div class="left-section d-flex align-items-center">
              <img src="image/combine_logo.svg" class="header-logo" />
              <!-- <img src="image/Desynat Logo_Final 1.svg" class="header-logo" /> -->
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
                <h2 class="h2">Category & Sub-Cattegory Management</h2>
              </div>
            </div>

            <div class="userManagecontent">
              <div class="mt-4">
                <div class="align-items-end d-flex">
                  <div class="search-box" style="position: relative">
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
                        <th scope="col">Category Name</th>
                        <th scope="col">Manage Sub-Category</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">1</th>

                        <td>Men</td>
                        <td>
                          <a
                            class="btn btn-dark customBtn"
                            href="{{route('manageSubCategory')}}"
                          >
                            <span>Manage</span>
                          </a>
                        </td>
                        <td>
                          <div class="d-flex gap-3 justify-content-center">
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

                        <td>Men</td>
                        <td>
                          <a
                            class="btn btn-dark customBtn"
                            href="{{route('manageSubCategory')}}"
                          >
                            <span>Manage</span>
                          </a>
                        </td>
                        <td>
                          <div class="d-flex gap-3 justify-content-center">
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
    @endsection


