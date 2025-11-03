@extends('admin.layout.app')
@section('content')
      <div id="content-wrapper" class="d-flex flex-column position-relative">
        <div id="content" class="">
        

          <div class="inner-content management">
            <div class="row align-items-center justify-content-between">
              <div class="col-lg-6 col-md-6 col-12">
                <h2 class="h2">Category & Sub-Cattegory Management</h2>
              </div>
            </div>

            <div class="userManagecontent">
              <div class="mt-4">
                <!-- <div class="align-items-end d-flex">
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
                </div> -->

                <div class=" w-100">
                  <table id="myTable" class="table w-100">
                    <thead>
                      <tr>
                        <th scope="col">SR No.</th>
                        <th scope="col">Image</th>
                        <th scope="col">Category Name</th>
                        <th scope="col">Manage Sub-Category</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($Categories as $key => $category)
                      <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>
                            <img
                                src="{{ $category->image }}"
                                width="40px"
                                height="40px"
                                class="square"
                            />
                        </td>

                        <td>{{$category->name}}</td>
                        <td>
                          <a
                            class="btn btn-dark customBtn"
                             href="{{ route('manageSubCategory', ['id' => $category->id]) }}"
                          >
                            <span>Manage</span>
                          </a>
                        </td>
                        <td>{{ $category->status == 1 ? 'Active' : 'Inactive' }}</td>
                        <td>
                          <div class="form-check form-switch">
                              <input
                                  class="form-check-input toggleStatus"
                                  type="checkbox"
                                  role="switch"
                                  id="switch{{ $category->id }}"
                                  data-id="{{ $category->id }}"
                                  {{ $category->status == 1 ? 'checked' : '' }}
                              />
                          </div>
                        </td>
                      </tr>
                      @empty
                          <tr>
                              <td colspan="4" class="text-center text-muted">No Category found</td>
                          </tr>
                      @endforelse
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

  <!-- Update Category Status -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggleStatus').forEach(toggle => {
        toggle.addEventListener('change', function () {
            let categoryId = this.getAttribute('data-id');

            fetch(`/admin/updateCategoryStatus/${categoryId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    toastr.success(data.message);
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    toastr.error(data.message);
                }
            })
            .catch(error => {
                //console.error(error);
                toastr.error('Something went wrong while updating status.');
            });
        });
    });
});
</script>


