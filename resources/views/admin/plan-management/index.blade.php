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
                <h2 class="h2">{{ __('admin_messages.subscription_plan_management') }}</h2>
              </div>

            </div>

            <div class="userManagecontent mt-5">
              <div class="">

                <div class="table-responsive w-100">
                  <table id="myTable" class="table w-100">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('admin_messages.s_no') }}</th>
                            <th scope="col">{{ __('admin_messages.country') }}</th>
                            @if(in_array(6, $permissions) || $admin->type == 1)
                            <th scope="col">{{ __('admin_messages.manage_plan') }}</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($countries as $index => $country)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $country->name }}</td>
                                @if(in_array(6, $permissions) || $admin->type == 1)
                                <td>
                                    <a 
                                        class="btn btn-dark customBtn"
                                        href="{{ route('managePlans', ['id' => $country->id]) }}"
                                    >
                                        <span>{{ __('admin_messages.manage_plan') }}</span>
                                    </a>
                                </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No Plan available for this country</td>
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


    @endsection