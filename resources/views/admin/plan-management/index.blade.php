@extends('admin.layout.app')
@section('content')
 

  <div id="content-wrapper" class="d-flex flex-column position-relative">
        <div id="content" class="">
        

          <div class="inner-content management">
            <div class="row align-items-center justify-content-between">
              <div class="col-lg-6 col-md-6 col-12">
                <h2 class="h2">Subscription Plan Management</h2>
              </div>

            </div>

            <div class="userManagecontent">planManagement
              <div class="">
                <div class="align-items-end d-flex">
                  <div
                    class="search-box"
                    style="position: relative; "
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
                        <th scope="col">Country Name</th>
                        <th scope="col">Manage Plan</th>
                      
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">1</th>
                        <td>Dubai  </td>
                        <td>    <a
                            class="btn btn-dark customBtn"
                            href="{{route('managePlans')}}"
                          >
                            <span>Manage Plan</span>
                          </a></td>
                      
                      </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>Dubai  </td>
                        <td>    <a
                            class="btn btn-dark customBtn"
                            href="{{route('managePlans')}}"
                          >
                            <span>Manage Plan</span>
                          </a></td>
                      
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


    @endsection