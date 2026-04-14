@extends('admin.layout.app')
@section('content')

      <div id="content-wrapper" class="d-flex flex-column position-relative">
        <div id="content" class="">
    
          <div class="inner-content management">
            <div class="row align-items-center justify-content-between">
              <div class="col-lg-6 col-md-6 col-12">
                <h2 class="h2">Current Live Seller</h2> 
              </div>

            </div>

            <div class="userManagecontent">
              <div class="mt-4">
                <div class="table-responsive w-100">
                  <table id="myTable" class="table w-100">
                    <thead>
                      <tr>
                        <th scope="col">SR No.</th>
                        <th scope="col">Seller Name</th>
                        <th scope="col">Country</th>
                        <th scope="col">Watch Live</th>
                        <th scope="col">Lived On</th>
                      </tr>
                    </thead>
                    <tbody>
                          <tr>
                              <td>1</td>
                              <td>Manoj</td>
                              <td>UAE</td>
                              <td>
                                <div data-bs-toggle="modal" data-bs-target="#videoshow"><i class="bi bi-eye-fill"></i></div>
                              </td>
                              <td>14 April 2026 | 11 PM</td>
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

      <!-- Add Brand Modal -->
        <div class="modal fade" id="videoshow" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                  <div class="modal-header management border-0">
                      <h2 class="h2"></h2>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <div class="modal-body">
                      <div class="appointment-container">
                         <iframe width="100%" height="315" src="https://www.youtube.com/embed/EngW7tLk6R8?si=6LGUmyX9hc7GA9Vv" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                      </div>
                  </div>
              </div>
          </div>
        </div>

   


    </div>
    
@endsection










