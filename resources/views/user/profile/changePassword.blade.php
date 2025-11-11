@extends('user.profile.layout.app')

@section('content')

  <!-- //change password -->
    <div class="my-profile customContainer">
        <div class="d-flex align-items-center mt-3 justify-content-between">
            <span><a class="text-black" href="{{route('userProfile')}}"><i class="fa-solid fa-chevron-left"></i></a>Change Password</span>
        </div>
        <form id="changePassword">
            @csrf
        <div class="row mt-5">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Old Password</label>
                    <input type="text" class="form-control notapplyspace" placeholder="Enter Password"  name="old_password"/>
                    <p class="text-danger" id="error-old_password"></p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Enter New Password</label>
                    <input type="text" class="form-control notapplyspace" placeholder="Enter New Password" name="new_password"/>
                    <p class="text-danger" id="error-new_password"></p>
                </div>
            </div>
            <div class="col-lg-6 mt-3">
                <div class="form-group">
                    <label for="">Confirm Password</label>
                    <input type="text" class="form-control notapplyspace" placeholder="Re-Enter Password" name="confirm_password" />
                    <p class="text-danger" id="error-confirm_password"></p>
                </div>
            </div>
            <div class="col-lg-12">
                <button  type="submit"  class="customBtn w-100 mt-4" id="loginButtom">Update</button>
            </div>
        </div>
        </form>

    </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

        $(document).on('submit', '#changePassword', function (e) {
            e.preventDefault();
            let data = new FormData(this);
            
            $('#loginButtom').prop('disabled', true);

            $.ajax({
                url: "{{ route('userChangePassword') }}",
                method: "POST",
                data: data,
                processData: false,
                contentType: false, 
                success: function (resp) {
                    if(resp.status == true){
                             toastr.success(resp.message);
                        setTimeout(() => {
                             location.href = "/profile";
                        }, 1000);
                    }

                    if(resp.status == false){
                        for (const key in resp.errors) {
                            console.log(resp.errors[key])
                            $(`#error-${key}`).html(resp.errors[key]);
                        }   
                    }

                },
                error: function (xhr) {
                   toastr.error(xhr.responseJSON.message);
                },
                complete: function () {
                   $('#loginButtom').prop('disabled', false);
                }
            });
        });


    </script>
@endsection

