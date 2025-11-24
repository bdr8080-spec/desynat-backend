@extends('admin.layout.app')
@section('content')


<div class="inner-content management">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">USER MANAGEMENT</h2>
        </div>
    </div>

    <div class="userManagecontent mb-4">
        <div class="">
            <form method="GET" action="{{ route('admin.userManagement') }}" id="filterForm">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from" name="from_date" value="{{ request()->from_date }}" onchange="document.getElementById('filterForm').submit();" class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">To:</label>
                            <input type="date" id="to" name="to_date" value="{{ request()->to_date }}" onchange="document.getElementById('filterForm').submit();" class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">Country Name</label>
                            <select name="country_id" id="country_id"
                                class="form-select form-select-lg "
                                onchange="document.getElementById('filterForm').submit();">
                                <option value="">Select country</option>
                                @foreach($countries as $country)
                                <option value="{{ $country['id'] }}"
                                    {{ request('country_id') == $country['id'] ? 'selected' : '' }}>
                                    {{ $country['name'] }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 ">
                        <div class="d-flex gap-3 justify-content-end" >
                            <a href="{{route('admin.userManagement')}}" class="btn btn-dark customBtn"
                                style="margin-top: 70px">
                                <span>Reset</span>
                            </a>
                             <a class="btn btn-dark customBtn " style="margin-top: 70px">
                                <span>Export </span></a>
                        </div>
                    </div>
                    <!-- <div class="col-md-2 col-lg-1 col-12 mt-5">
                        <div class="d-dlex justify-content-end" style="text-align: end">
                            <a class="btn btn-dark customBtn button">
                                <span>Export </span></a>
                        </div>
                    </div> -->
                </div>
            </form>
            <div class="table-responsive  mt-5">
                <table id="myTable" class="table w-100">
                    <thead>
                        <tr>
                            <th scope="col">SR No.</th>
                            <th scope="col">Joining Date</th>
                            <th scope="col">Name</th>
                            <th scope="col">Image</th>
                            <th scope="col">Phone number</th>
                            <th scope="col">Country</th>
                            <th scope="col">Email</th>
                            <th scope="col">Total Number of Completed Order</th>
                            <th scope="col">Total Number of Cancelled Orders</th>
                            <th scope="col">Wallet Balance</th>
                            <th scope="col">Add Amount in Wallet</th>
                            <th scope="col">Block/Unblock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>

                            <td>{{ \Carbon\Carbon::parse($user['created_at'])->format('d-m-Y') }}</td>
                            <td>{{ $user['full_name'] }}</td>
                            <td>
                                <img src="{{ $user['profile_image'] }}" alt="" width="60px" height="60px" class="square" />
                            </td>
                            <td>{{ $user['country_code'] }}{{ $user['mobile'] }}</td>
                            <td>{{ $user->country_info ? $user->country_info->name : 'N/A' }}</td>
                            <td>{{ $user['email'] }}</td>
                            <td>N/A</td>
                            <td>N/A</td>
                            @php
                                $amount = $user->wallet_info ? $user->wallet_info->amount : null;
                            @endphp

                            <td>
                                
                                @if($amount !== null && $amount !== 'N/A')
                                    @if(fmod($amount, 1) == 0)
                                        {{ number_format($amount, 0) }}
                                    @else
                                        {{ number_format($amount, 2) }}
                                    @endif
                                @else
                                    0
                                @endif
                                KD
                            </td>
                            <td>
                                <a class="btn btn-dark customBtn" data-bs-toggle="modal" data-bs-target="#sentModal2" data-user-id="{{ $user['id'] }}">
                                    <span>Add</span>
                                </a>
                            </td>
                            <td>
                                <div class="d-flex gap-3 justify-content-center">
                                    <div class="form-check form-switch" style="justify-content: center;">
                                        <input class="form-check-input toggleStatus" type="checkbox"
                                            id="flexSwitchCheckChecked" data-id="{{ $user['id'] }}"
                                            {{ $user['status'] == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="sentModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Add Amount</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body m-auto mb-2">
                <input type="hidden" id="userIdForWallet">
                <div class="form-group w-100">
                    <label for="walletAmount" class="form-label">Enter Amount</label>
                    <input type="text" id="walletAmount" oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/(\..*)\./g,'$1').replace(/^(\d+)(\.\d{0,2}).*$/,'$1$2');" class="form-control w-100" />
                    <small id="amountError" class="text-danger" style="display:none;">Please Enter Amount</small>
                </div>
                <div class="d-flex justify-content-center gap-3 mt-4">
                    <button type="button" class="btn btn-dark customBtn" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-dark customBtn" id="submitWalletAmount">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- block unblock user -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.toggleStatus').forEach(toggle => {
        toggle.addEventListener('change', function() {
            let userId = this.getAttribute('data-id');
            let isChecked = this.checked;

            fetch(`/admin/blockUnblockUser/${userId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        is_block: isChecked ? 0 : 1
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        if (isChecked) {
                            toastr.success(data.message);
                        } else {
                            toastr.error(data.message);
                        }
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    } else {
                        toastr.error(data.message);
                        this.checked = !isChecked;
                    }
                })
                .catch(error => {
                    toastr.error('Something went wrong while updating status.');
                    this.checked = !isChecked;
                });
        });
    });
});
</script>

<!-- add wallet amount -->
 <script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-bs-target="#sentModal2"]').forEach(btn => {
        btn.addEventListener('click', function() {
            const userId = this.closest('tr').querySelector('.toggleStatus').getAttribute('data-id');
            document.getElementById('userIdForWallet').value = userId;
            document.getElementById('walletAmount').value = '';
            document.getElementById('amountError').style.display = 'none';
        });
    });

    document.getElementById('walletAmount').addEventListener('input', function() {
        document.getElementById('amountError').style.display = 'none';
    });

    document.getElementById('submitWalletAmount').addEventListener('click', function() {
        const userId = document.getElementById('userIdForWallet').value;
        const amount = document.getElementById('walletAmount').value.trim();

        if (amount === '' || isNaN(amount) || parseFloat(amount) <= 0) {
            document.getElementById('amountError').style.display = 'block';
            return;
        }

        fetch(`/admin/addUserWalletAmount`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ user_id: userId, amount: amount })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                toastr.success(data.message);
                $('#sentModal2').modal('hide');
                setTimeout(() => location.reload(), 2000);
            } else {
                toastr.error(data.message);
            }
        })
        .catch(() => {
            toastr.error('Something went wrong while adding amount.');
        });
    });
});
</script>
