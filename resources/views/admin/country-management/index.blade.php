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
                    <h2 class="h2">COUNTRY , CITY & ZONE MANAGEMENT</h2>
                </div>
            </div>

            <div class="userManagecontent">
                <div class="mt-4">
                    <!-- <div class="align-items-end d-flex">
                        <div class="search-box" style="position: relative">
                            <i class="bi bi-search" style="
                        position: absolute;
                        left: 10px;
                        top: 50%;
                        transform: translateY(-50%);
                        font-size: 16px;
                        color: #888;
                      ">
                            </i>
                            <input type="text" class="form-control" placeholder="Search for..."
                                style="padding-left: 35px" />
                        </div>
                    </div> -->

                    <div class="table-responsive w-100">
                        <table id="myTable" class="table w-100">
                            <thead>
                                <tr>
                                    <th scope="col">SR No.</th>
                                    <th scope="col">Country Name</th>
                                    @if(in_array(5, $permissions) || $admin->type == 1)
                                    <th scope="col">Manage City</th>
                                    @endif
                                    <!-- <th scope="col">Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($countries as $index => $country)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>

                                        <td>{{ $country->name }}</td>
                                        @if(in_array(5, $permissions) || $admin->type == 1)
                                        <td>
                                            <a class="btn btn-dark customBtn" href="{{ route('manageCities', ['id' => $country->id]) }}">
                                                <span>Manage</span>
                                            </a>
                                        </td>
                                        @endif

                                        <!-- <td>
                                            <div class="d-flex gap-3 justify-content-center">
                                                <div class="form-check form-switch">
                                                    <input 
                                                        class="form-check-input toggleStatus" 
                                                        type="checkbox" 
                                                        role="switch"
                                                        id="switch{{ $country->id }}"
                                                        data-id="{{ $country->id }}"
                                                        {{ $country->status == 1 ? 'checked' : '' }}
                                                    />
                                                    <label class="form-check-label"></label>
                                                </div>
                                            </div>
                                        </td> -->
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No countries found</td>
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