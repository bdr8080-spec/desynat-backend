
@include('affiliatedUser.layout.header')

<section class="section dashboard page-100">
    

    <div class="login_contenar">
       
        <div class="login_content login_content-box">
            <div class="login_content_content align-self-center">
                <form action="{{ route('affiliate.userOldNumberSendOtp') }}" method="POST">
            @csrf
                <div class="otp-page">
                    <h3 class="h3-heading">
                        <a href="javascript:history.back()" class="text-dark me-2">
                            <i class="fa-solid fa-chevron-left"></i></a>{{ __('affiliate_messages.change_email_address') }}
                    </h3>

                    <h6 class="otp_sent">
                        {{ __('affiliate_messages.great') }}! {{ __('affiliate_messages.now_enter_email_address_you_want_to_continue_with') }}
                    </h6>

                    <div class="form-group mt-3">
                        <div class="d-flex gap-2">
                            <div class="w-100 LoginMobileDesign">
                                <input type="text" class="form-control notapplyspace"
                                    placeholder="{{ __('affiliate_messages.please_enter_email_address') }}"
                                    name="email" id="LoginMobile">
                            </div>
                        </div>
                    </div>


                    <input type="hidden" name="for" value="email">
                    <input type="hidden" name="type" value="1"> 

                    <button type="submit" class="customBtn customBtn5 mt-5 w-100">{{ __('affiliate_messages.continue') }}</button>
                </div>
            </form>
        </div>
        </div>
     </div>


     <!-- Modal -->
    <div class="modal fade" id="verificationEmailConfirm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="assets/images/success.svg" class="img-fluid" />
                    <p>Email Verification Link Sent Successfully!</p>
                </div>
            </div>
        </div>
    </div>

<script>
@if (session('success'))
    toastr.success("{{ session('success') }}");
@endif

@if (session('error'))
    toastr.error("{{ session('error') }}");
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
        toastr.error("{{ $error }}");
    @endforeach
@endif
</script>

</section>

@include('affiliatedUser.layout.footer')