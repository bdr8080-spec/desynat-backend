@extends('user.auth.layout.app')
    
@section('content')
    <div class="login_contenar">
        <header class="inner-header">
            <a><img src="assets/images/logo.svg" class="img-fluid" /></a>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="assets/images/global.svg" class="img-fluid" /> EN
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><span>AR</span> Arabic</a></li>
                    <li><a class="dropdown-item" href="#"><span>EN</span> English</a></li>
                </ul>
            </div>
        </header>
        <div class="login_content login_content_left">
            <img src="assets/images/left-img.svg" class="left-imgone" />
            <img src="assets/images/logoone.svg" class="left-img" />
            <img src="assets/images/right-img.svg" class="left-imgtwo" />
        </div>
        <div class="login_content login_content_right">
            <div class="login_content_content align-self-center">
                <div>
                    <h3 class="h3-heading"><span><a href="{{ url()->previous() }}"><i class="fa-solid fa-chevron-left"></i></a></span>Forgot Password</h3>
                    <form id="forgetPassword">
                        @csrf
                    <div class="radio-group my-4">
                        <label class="custom-radio">
                            <input type="radio" name="forgetPassword" class="emailandmobile notapplyspace" value="1"  checked />
                            <span class="radio-mark"></span>
                            <span class="label-text">Mobile Number</span>
                        </label>

                        <label class="custom-radio">
                            <input type="radio" name="forgetPassword"  class="emailandmobile" value="2" />
                            <span class="radio-mark"></span>
                            <span class="label-text">Email Address</span>
                        </label>
                    </div>
                   
                    <div class="form-group position-relative password_icon mt-3 mobileInput">
                        <label for="">Enter Mobile Number</label>
                        <div class="row">
                            <div class="col-3">
                        <select name="country_code" id="" class="form-control">
                            @foreach ($country as $item)                       
                                <option value="{{$item->dial_code}}">{{$item->dial_code}}</option>
                            @endforeach
                        </select>
                        </div>
                        <div class="col-9">
                        <input type="number" class="form-control"  value="" placeholder="Enter Mobile Number" name="mobile">
                        </div>
                        </div>
                        <p class="text-danger" id="error-mobile"></p>
                        </div>
                    </div>

                    <div class="form-group position-relative password_icon mt-3 d-none emailInput">
                        <label for="">Enter Email Id</label>
                        <input class="form-control notapplyspace" type="email" placeholder="Enter Mobile Number" name="email">
                          <p class="text-danger" id="error-email"></p>
                    </div>
                    <button type="submit" class="customBtn mt-4">Continue</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>

    $('.emailandmobile').on('click', function(e){
    
      let id = $(this).val();
      
        if (id == '2') {
            $('.emailInput').addClass('d-block').removeClass('d-none');
            $('.mobileInput').addClass('d-none').removeClass('d-block');
        } else {
            $('.emailInput').addClass('d-none').removeClass('d-block');
            $('.mobileInput').addClass('d-block').removeClass('d-none');
        }




    })


        $(document).on('submit', '#forgetPassword', function (e) {
            e.preventDefault();

            let data = new FormData(this);
            
            $('#loginButtom').prop('disabled', true);

            $.ajax({
                url: "{{ route('userForgetPassword') }}",
                method: "POST",
                data: data,
                processData: false,
                contentType: false, 
                success: function (resp) {
                    if(resp.status == true){
                        location.href = `verify-otp?temp_user_id=${resp.id}&forget_password=one`;
                    }

                    if(resp.status == false){
                        for (const key in resp.errors) {
                            console.log(resp.errors[key])
                            $(`#error-${key}`).html(resp.errors[key]);
                        }   
                    }

                },
                error: function (xhr) {
                    if(xhr.responseJSON.status==false){
                            toastr.error(xhr.responseJSON.message);
                    }
               
                },
                complete: function () {
                   $('#loginButtom').prop('disabled', false);
                }
            });
        });

     </script>

@endsection