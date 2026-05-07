@extends('admin.layout.app')
@section('content')
@php
    $admin = auth('admin')->user();

    $permissions = \App\Models\AdminPermission::where('admin_id', $admin->id)
        ->where('can_action', 1)
        ->pluck('module_id')
        ->toArray();
@endphp
      <div id="content-wrapper" class="d-flex flex-column position-relative">
        <div id="content" class="">
        

          <div class="inner-content management">
            <div class="row align-items-center justify-content-between">
              <div class="col-lg-6 col-md-6 col-12">
                <h2 class="h2">{{ __('admin_messages.category_sub_category_management') }}</h2> 
              </div>
            </div>

            <div class="userManagecontent mt-5 ">
              <div class="">
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

                <div class="table-responsive w-100">
                  <table id="myTable" class="table w-100">
                    <thead>
                      <tr>
                        <th scope="col">{{ __('admin_messages.s_no') }}</th>
                        <th scope="col">{{ __('admin_messages.image') }}</th>
                        <th scope="col">{{ __('admin_messages.category_name') }}</th>
                        @if(in_array(3, $permissions) || $admin->type == 1)
                        <th scope="col">{{ __('admin_messages.manage_sub_category') }}</th>
                        @endif
                        <th scope="col">{{ __('admin_messages.status') }}</th>
                        @if(in_array(3, $permissions) || $admin->type == 1)
                        <th scope="col">{{ __('admin_messages.action') }}</th>
                        @endif
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
                         @if(app()->getLocale() == 'en')
                        <td>{{$category->name}}</td>
                        @endif
                         @if(app()->getLocale() == 'ar')
                        <td>{{$category->name_ar}}</td>
                        @endif
                        @if(in_array(3, $permissions) || $admin->type == 1)
                        <td>
                          <a
                            class="btn btn-dark customBtn"
                             href="{{ route('manageSubCategory', ['id' => $category->id]) }}"
                          >
                            <span>{{ __('admin_messages.manage') }}</span>
                          </a>
                        </td>
                        @endif
                        <td>
                            {{ $category->status == 1
                                ? __('admin_messages.active')
                                : __('admin_messages.inactive')
                            }}
                        </td>
                        @if(in_array(3, $permissions) || $admin->type == 1)
                        <td>
                          <div class="form-check form-switch" style="justify-content: center;">
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
                        @endif
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
                    // toastr.success(data.message);
                    if(data.status == 1){
                        toastr.success(data.message); // Green for active
                    } else {
                        toastr.error(data.message);   // Red for deactivated
                    }
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


