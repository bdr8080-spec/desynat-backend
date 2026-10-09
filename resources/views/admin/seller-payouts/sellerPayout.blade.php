@extends('admin.layout.app')
@section('content')


<div id="content-wrapper" class="d-flex flex-column position-relative">
    <div id="content" class="">

        <div class="inner-content management">
            <div class="d-flex align-items-center gap-3 mt-2 justify-content-between">
                <div class="d-flex align-items-center gap-3 mt-2">
                    <div class="arrow">
                        <a href="{{route('admin.payouts')}}" class="table-button">
                            <i class="fas fa-angle-left"></i>
                        </a>
                    </div>
                    <h2 class="h2 text-start">View Seller Payouts</h2>
                </div>

                <a class="btn btn-dark customBtn" data-bs-toggle="modal" data-bs-target="#addModal2"> <span>Add
                        Payout</span></a>
            </div>

            <div class="row">
                <div class="col-lg-2 col-md-3 col-12">
                    <div class="form-group  w-100">
                        <label for="from" class="form-label">From</label>
                        <input type="date" class="form-control datepicker" />
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-12">
                    <div class="form-group  w-100">
                        <label for="from" class="form-label">To</label>
                        <input type="date" class="form-control datepicker" />
                    </div>
                </div>

                <!-- <div class="col-lg-2 col-md-3 col-12">
                    <div class="form-group  w-100">
                        <label for="from" class="form-label">Country</label>
                        <select class="form-select form-select-lg">
                            <option value="">Oman</option>
                        </select>
                    </div>
                </div> -->

                <div class="col-lg-6 col-md-6 col-12 d-flex  align-items-end">
                    <h5 class="text-color" style="color:#ac875e;">Total Pending Payout:- KD 100000</h5>
                </div>

            </div>

            <div class="userManagecontent mt-4">
                <div class="table-responsive w-100">
                    <table id="myTable" class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Date</th>
                                <th scope="col">Payout Amount</th>
                                <th scope="col">Transaction ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>20th Dec 2024 </td>
                                <td>OMR 1000</td>
                                <td>#Tr887677</td>
                            </tr>
                            <tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Add Brand Modal -->
<div class="modal fade" id="addModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Add Payout</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <form>
                        <div class="row">
                            <!-- Amount -->
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="brand name">Amount</label>
                                    <input type="text" class="form-control" placeholder="Enter Amount"
                                        oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')" />

                                </div>
                            </div>

                            <!--Transaction  -->
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="brand name">Transaction ID </label>
                                    <input type="text" class="form-control" placeholder="Enter Transaction ID">
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                                <a type="button" id="submitBrandBtn" class="btn btn-dark customBtn mt-3">Submit</a>
                            </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection