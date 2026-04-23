@extends('admin.layout.app')
@section('content')

<style>
/* Hide all tab panes initially to avoid flicker */
.tab-content > .tab-pane {
    display: none;
}

/* Show only the active tab pane */
.tab-content > .tab-pane.active {
    display: block;
}

/* Hide entire tab container initially */
#tabContentContainer {
    visibility: hidden;
}

/* Show tab container after JS activates the saved tab */
#tabContentContainer.active-shown {
    visibility: visible;
}
</style>

@php
    $admin = auth('admin')->user();

    $permissions = \App\Models\AdminPermission::where('admin_id', $admin->id)
        ->where('can_action', 1)
        ->pluck('module_id')
        ->toArray();
@endphp



<div class="inner-content management mb-5" id="tabContentContainer">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">CMS Management </h2>
        </div>
    </div>

    <div class="cms-wapper">
        <!-- Main Tabs: User / Dealer -->
        <div class="d-flex justify-content-center mb-3">
            <ul class="nav nav-pills tabs-pnl custom" id="mainTab" role="tablist">
                <li class="nav-item m-1" role="presentation">
                    <button class="nav-link customBtn2 active m-0" id="user-tab" data-bs-toggle="pill"
                        data-bs-target="#userContent" type="button" role="tab" aria-controls="userContent"
                        aria-selected="true">
                        User
                    </button>
                </li>
                <li class="nav-item m-1" role="presentation">
                    <button class="nav-link customBtn2 m-0" id="dealer-tab" data-bs-toggle="pill"
                        data-bs-target="#dealerCmsTabContent" type="button" role="tab"
                        aria-controls="dealerCmsTabContent" aria-selected="false">
                        Seller
                    </button>
                </li>
                <li class="nav-item m-1" role="presentation">
                    <button class="nav-link customBtn2 m-0" id="delivery-tab" data-bs-toggle="pill"
                        data-bs-target="#deliveryboy" type="button" role="tab"
                        aria-controls="deliveryboy" aria-selected="false">
                       Delivery Boy
                    </button>
                </li>
            </ul>
        </div>

        <!-- Main Tab Content -->
        <div class="tab-content" id="mainTabContent">
            <!-- USER CMS TABS -->
            <div class="tab-pane fade show active" id="userContent" role="tabpanel" aria-labelledby="user-tab">
                <!-- Inner Tabs for CMS -->
                <div class="d-flex justify-content-center mb-3">
                    <ul class="nav nav-pills tabs-pnl custom" id="userCmsTab" role="tablist">
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 active m-0" id="pills-home-tab-user"
                                data-bs-toggle="pill" data-bs-target="#pills-home-user" type="button" role="tab"
                                aria-controls="pills-home-user" aria-selected="true">
                                Terms & Conditions
                            </button>
                        </li>

                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 m-0" id="pills-privacy-tab-user" data-bs-toggle="pill"
                                data-bs-target="#pills-privacy-user" type="button" role="tab"
                                aria-controls="pills-privacy-user" aria-selected="false">
                                Return Policy
                            </button>
                        </li>
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 m-0" id="pills-about-tab-user" data-bs-toggle="pill"
                                data-bs-target="#pills-about-user" type="button" role="tab"
                                aria-controls="pills-about-user" aria-selected="false">
                                About Us
                            </button>
                        </li>
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 m-0" id="pills-cancel-tab-user" data-bs-toggle="pill"
                                data-bs-target="#pills-cancel-user" type="button" role="tab"
                                aria-controls="pills-cancel-user" aria-selected="false">
                                Cancellation Policy
                            </button>
                        </li>
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 m-0" id="pills-exchange-tab-user" data-bs-toggle="pill"
                                data-bs-target="#pills-exchange-user" type="button" role="tab"
                                aria-controls="pills-exchange-user" aria-selected="false">
                                Exchange Policy
                            </button>
                        </li>
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 m-0" id="pills-faq-tab-user" data-bs-toggle="pill"
                                data-bs-target="#pills-faq-user" type="button" role="tab" aria-controls="pills-faq-user"
                                aria-selected="false">
                                FAQs
                            </button>
                        </li>
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 m-0" id="pills-contact-tab-user" data-bs-toggle="pill"
                                data-bs-target="#pills-contact-user" type="button" role="tab"
                                aria-controls="pills-contact-user" aria-selected="false">
                                Contact Us
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- User CMS Tab Content -->

                <div class="tab-content" id="userCmsTabContent">
                    <!-- Terms & Conditions -->
                   
                        <div class="tab-pane fade show active" id="pills-home-user" role="tabpanel"
                            aria-labelledby="pills-home-tab-user">
                            <form id="userTermsForm">
                            <div class="d-flex border-bottom align-items-center mb-3">
                                <h6 class="flex-grow-1 text-start">Terms & Conditions</h6>
                                <input type="hidden" name="type" value="1">

                                <!-- <a class="table-button eyebox mb-2" type="button" data-bs-toggle="modal"
                                    data-bs-target="#editModal">
                                    <i class="bi bi-pencil-square"></i>
                                </a> -->
                            </div>

                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>English</h6>
                                        <!-- <a class="table-button eyebox mb-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a> -->
                                    </div>
                                    <div class="editor-wapper mt-2">
                                        <div class="editor">
                                            <textarea id="content_english" name="content_english" class="ckeditorfile"
                                                rowspan="5">
                                                {!! $userterms->content_english ?? '' !!}
                                            </textarea>
                                        </div>
                                        <span class="error-text text-danger" id="error_content_english"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>Arabic</h6>
                                        <!-- <a class="table-button eyebox mb-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a> -->
                                    </div>
                                    <div class="editor-wapper mt-2">
                                        <div class="editor">
                                            <textarea id="content_arabic" name="content_arabic" class="ckeditorfile">
                                            {!! $userterms->content_arabic ?? '' !!}   
                                        </textarea>
                                        </div>
                                        <span class="error-text text-danger" id="error_content_arabic"></span>
                                    </div>
                                </div>
                            </div>
                            @if(in_array(24, $permissions) || $admin->type == 1)
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn customBtn2 active text-white">
                                    Submit
                                </button>
                            </div>
                            @endif

                        </form>
                        </div>

                    <!-- return Policy -->
                    
                        <div class="tab-pane fade" id="pills-privacy-user" role="tabpanel"
                            aria-labelledby="pills-privacy-tab-user">
                            <form id="userReturnForm">
                            <div class="d-flex border-bottom align-items-center mb-3">
                                <h6 class="flex-grow-1 text-start">Retrun Policy</h6>

                            </div>
                            <input type="hidden" name="type" value="1">

                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>English</h6>
                                        <!-- <a class="table-button eyebox mb-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a> -->
                                    </div>
                                    <div class="editor-wapper mt-2">
                                        <div class="editor">
                                            <textarea name="content_english_return" id="content_english_return"
                                                class="ckeditorfile" rowspan="5">
                                                {!! $userreturn->content_english ?? '' !!}
                                            </textarea>
                                        </div>
                                        <span class="error-text text-danger" id="error_content_english_return"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>Arabic</h6>
                                        <!-- <a class="table-button eyebox mb-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a> -->
                                    </div>
                                    <div class="editor-wapper mt-2">
                                        <div class="editor">
                                            <textarea name="content_arabic_return" id="content_arabic_return"
                                                class="ckeditorfile">
                                                {!! $userreturn->content_arabic ?? '' !!}
                                            </textarea>
                                        </div>
                                        <span class="error-text text-danger" id="error_content_arabic_return"></span>
                                    </div>
                                </div>
                            </div>
                            @if(in_array(24, $permissions) || $admin->type == 1)
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn customBtn2 active text-white">
                                    Submit
                                </button>
                            </div>
                            @endif
                        </form>
                        </div>

                    <!-- About Us -->
                  
                        <div class="tab-pane fade" id="pills-about-user" role="tabpanel"
                            aria-labelledby="pills-about-tab-user">
                            <form id="userAboutForm">
                            <div class="d-flex border-bottom align-items-center mb-3">
                                <h6 class="flex-grow-1 text-start">About Us</h6>

                            </div>
                            <input type="hidden" name="type" value="1">
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>English</h6>
                                        <!-- <a class="table-button eyebox mb-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a> -->
                                    </div>
                                    <div class="editor-wapper mt-2">
                                        <div class="editor">
                                            <textarea name="content_english_about" id="content_english_about"
                                                class="ckeditorfile" rowspan="5">
                                                {!! $userabout->content_english ?? '' !!}
                                            </textarea>
                                        </div>
                                        <span class="error-text text-danger" id="error_content_english_about"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>Arabic</h6>
                                        <!-- <a class="table-button eyebox mb-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a> -->
                                    </div>
                                    <div class="editor-wapper mt-2">
                                        <div class="editor">
                                            <textarea name="content_arabic_about" id="content_arabic_about"
                                                class="ckeditorfile">
                                                {!! $userabout->content_arabic ?? '' !!}
                                            </textarea>
                                        </div>
                                        <span class="error-text text-danger" id="error_content_arabic_about"></span>
                                    </div>
                                </div>
                            </div>
                            @if(in_array(24, $permissions) || $admin->type == 1)
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn customBtn2 active text-white">
                                    Submit
                                </button>
                            </div>
                            @endif
                        </form>
                        </div>
                    <!-- cancel-policy -->
                    
                        <div class="tab-pane fade" id="pills-cancel-user" role="tabpanel"
                            aria-labelledby="pills-cancel-tab-user">
                            <form id="userCancellationForm">
                            <div class="d-flex border-bottom align-items-center mb-3">
                                <h6 class="flex-grow-1 text-start">Cancellation Policy</h6>
                            </div>
                            <input type="hidden" name="type" value="1">
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>English</h6>
                                        <!-- <a class="table-button eyebox mb-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a> -->
                                    </div>
                                    <div class="editor-wapper mt-2">
                                        <div class="editor">
                                            <textarea name="content_english_cancellation"
                                                id="content_english_cancellation" class="ckeditorfile" rowspan="5">
                                            {!! $usercancellation->content_english ?? '' !!}
                                        </textarea>
                                        </div>
                                        <span class="error-text text-danger" id="error_content_english_cancellation"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>Arabic</h6>
                                        <!-- <a class="table-button eyebox mb-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a> -->
                                    </div>
                                    <div class="editor-wapper mt-2">
                                        <div class="editor">
                                            <textarea name="content_arabic_cancellation"
                                                id="content_arabic_cancellation" class="ckeditorfile">
                                            {!! $usercancellation->content_arabic ?? '' !!}
                                        </textarea>
                                        </div>
                                        <span class="error-text text-danger" id="error_content_arabic_cancellation"></span>
                                    </div>
                                </div>
                            </div>
                            @if(in_array(24, $permissions) || $admin->type == 1)
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn customBtn2 active text-white">
                                    Submit
                                </button>
                            </div>
                            @endif
                        </form>
                        </div>

                    <!-- exchange-policy -->
                   
                        <div class="tab-pane fade" id="pills-exchange-user" role="tabpanel"
                            aria-labelledby="pills-exchange-tab-user">
                            <form id="userExchangeForm">
                            <div class="d-flex border-bottom align-items-center mb-3">
                                <h6 class="flex-grow-1 text-start">Exchange Policy</h6>

                                <!-- <a class="table-button eyebox mb-2" type="button" data-bs-toggle="modal"
                                data-bs-target="#editModalAbout">
                                <i class="bi bi-pencil-square"></i>
                            </a> -->

                            </div>
                            <input type="hidden" name="type" value="1">
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>English</h6>
                                        <!-- <a class="table-button eyebox mb-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a> -->
                                    </div>
                                    <div class="editor-wapper mt-2">
                                        <div class="editor">
                                            <textarea name="content_english_exchange" id="content_english_exchange"
                                                class="ckeditorfile" rowspan="5">
                                            {!! $userexchange->content_english ?? '' !!}
                                        </textarea>
                                        </div>
                                        <span class="error-text text-danger" id="error_content_english_exchange"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>Arabic</h6>
                                        <!-- <a class="table-button eyebox mb-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a> -->
                                    </div>
                                    <div class="editor-wapper mt-2">
                                        <div class="editor">
                                            <textarea name="content_arabic_exchange" id="content_arabic_exchange"
                                                class="ckeditorfile">
                                            {!! $userexchange->content_arabic ?? '' !!}
                                        </textarea>
                                        </div>
                                        <span class="error-text text-danger" id="error_content_arabic_exchange"></span>
                                    </div>
                                </div>
                            </div>
                            @if(in_array(24, $permissions) || $admin->type == 1)
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn customBtn2 active text-white">
                                    Submit
                                </button>
                            </div>
                            @endif
                        </form>
                        </div>

                    <!-- FAQs -->
                    <div class="tab-pane fade" id="pills-faq-user" role="tabpanel" aria-labelledby="pills-faq-tab-user">
                        <div class="d-flex border-bottom align-items-center mb-3">
                            <h5 class="flex-grow-1 text-start">FAQs</h5>
                            @if(in_array(24, $permissions) || $admin->type == 1)
                            <a class="btn btn-dark customBtn mb-2" type="button" data-bs-toggle="modal"
                                data-bs-target="#faqquestionModal">Add New Question</a>
                            @endif
                        </div>
                        <div class="management mt-4 pb-5">
                            <h6>List of Questions(English)</h6>

                            <!-- <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            Accordion Item #1
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <strong>This is the first item’s accordion body.</strong> It is shown by
                                            default, until the
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                            <div class="faq-list-panle">
                                @forelse($userfaq as $index => $faq)
                                <div class="faq-english mb-3">
                                    <div class="form-grid">

                                        <div class="form-label">
                                            Question {{ $index + 1 }} (English)
                                        </div>
                                        <div class="form-text">
                                            {!! $faq->question_english ?? '' !!}
                                        </div>

                                        <div class="form-label">Answer (English)</div>
                                        <div class="form-text">
                                            {!! $faq->answer_english ?? '' !!}
                                        </div>

                                        <div class="form-label">
                                            Question {{ $index + 1 }} (Arabic)
                                        </div>
                                        <div class="form-text">
                                            {!! $faq->question_arabic ?? '' !!}
                                        </div>

                                        <div class="form-label">Answer (Arabic)</div>
                                        <div class="form-text">
                                            {!! $faq->answer_arabic ?? '' !!}
                                        </div>

                                    </div>
                                    @if(in_array(24, $permissions) || $admin->type == 1)
                                        <div class="d-flex gap-3 justify-content-end align-items-center">
                                            <a class="table-button editFaqBtn"
                                                href="#"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editFaqUserModal"
                                                data-id="{{ $faq->id }}"
                                                data-qe="{{ $faq->question_english }}"
                                                data-ae="{{ $faq->answer_english }}"
                                                data-qa="{{ $faq->question_arabic }}"
                                                data-aa="{{ $faq->answer_arabic }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a href="javascript:void(0);"
                                            class="table-button text-danger deleteFaq mb-1 mt-1"
                                            data-id="{{ $faq->id }}">
                                            <i class="bi bi-trash3-fill"></i>
                                            </a>
                                        </div>
                                        @endif

                                </div>
                                @empty
                                <div class="text-center text-muted">
                                    No FAQs found.
                                </div>
                                @endforelse
                            </div>


                        </div>
                    </div>

                    <!-- Contact Us -->
                    <div class="tab-pane fade" id="pills-contact-user" role="tabpanel"
                        aria-labelledby="pills-contact-tab-user">

                        <div class="d-flex border-bottom align-items-center mb-3">
                            <h5 class="flex-grow-1 text-start">Contact Us</h5>
                        </div>

                        <input type="hidden" value="1" name="type" />

                        <div class="contactUs mx-auto" style="max-width: 400px">

                            <div class="form-group mb-2">
                                <label class="form-label" for="email">Email id</label>
                                <input type="text" id="email" class="form-control space" name="email"
                                    placeholder="Enter Email"
                                    value="{{ $userContactUs->content_english['email'] ?? '' }}" />
                                <h6 class="text-danger error-email"></h6>
                            </div>

                            <div class="form-group mb-2">
                                <label class="form-label space" for="phone">Contact Number</label>
                                <input type="tel" id="mobile" class="form-control space" name="mobile"
                                    placeholder="Enter Mobile Number"
                                    oninput="this.value = this.value.replace(/[^0-9+]/g,'')"
                                    value="{{ $userContactUs->content_english['mobile'] ?? '' }}" />
                                <h6 class="text-danger error-mobile"></h6>
                            </div>

                            <div class="form-group mb-2">
                                <label class="form-label space" for="twitter">Whatsapp Number</label>
                                <input type="text" id="whatsapp" class="form-control" name="whatsapp"
                                    placeholder="Enter Whatsapp Number"
                                    oninput="this.value = this.value.replace(/[^0-9+]/g,'')"
                                    value="{{ $userContactUs->content_english['whatsapp'] ?? '' }}" />
                                <h6 class="text-danger error-whatsapp"></h6>
                            </div>
                            @if(in_array(24, $permissions) || $admin->type == 1)
                            <div class="d-flex justify-content-center mt-3">
                                <button type="button" id="contactSubmitBtn" class="btn btn-dark customBtn">
                                    <span>Submit</span>
                                </button>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade show" id="dealerCmsTabContent" role="tabpanel" aria-labelledby="dealer-tab">
                <!-- Inner Tabs for CMS -->
                <div class="d-flex justify-content-center mb-3">
                    <ul class="nav nav-pills tabs-pnl custom" id="dealerCmsTab" role="tablist">
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 active m-0" id="pills-home-tab-dealer"
                                data-bs-toggle="pill" data-bs-target="#pills-home-dealer" type="button" role="tab"
                                aria-controls="pills-home-dealer" aria-selected="true">
                                Terms & Conditions
                            </button>
                        </li>
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 m-0" id="pills-privacy-tab-dealer" data-bs-toggle="pill"
                                data-bs-target="#pills-privacy-dealer" type="button" role="tab"
                                aria-controls="pills-privacy-dealer" aria-selected="false">
                                Privacy Policy
                            </button>
                        </li>
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 m-0" id="pills-about-tab-dealer" data-bs-toggle="pill"
                                data-bs-target="#pills-about-dealer" type="button" role="tab"
                                aria-controls="pills-about-dealer" aria-selected="false">
                                About Us
                            </button>
                        </li>
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 m-0" id="pills-cancel-tab-dealer" data-bs-toggle="pill"
                                data-bs-target="#pills-cancel-dealer" type="button" role="tab"
                                aria-controls="pills-cancel-dealer" aria-selected="false">
                                Cancellation Policy
                            </button>
                        </li>
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 m-0" id="pills-exchange-tab-dealer" data-bs-toggle="pill"
                                data-bs-target="#pills-exchange-dealer" type="button" role="tab"
                                aria-controls="pills-exchange-dealer" aria-selected="false">
                                Exchange Policy
                            </button>
                        </li>
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 m-0" id="pills-faq-tab-dealer" data-bs-toggle="pill"
                                data-bs-target="#pills-faq-dealer" type="button" role="tab"
                                aria-controls="pills-faq-dealer" aria-selected="false">
                                FAQs
                            </button>
                        </li>
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 m-0" id="pills-contact-tab-dealer" data-bs-toggle="pill"
                                data-bs-target="#pills-contact-dealer" type="button" role="tab"
                                aria-controls="pills-contact-dealer" aria-selected="false">
                                Contact Us
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- DEALER CMS Tab Content -->
                <div class="tab-content" id="dealerCmsTabContent">
                    <!-- Terms & Conditions -->
                   
                        <div class="tab-pane fade show active" id="pills-home-dealer" role="tabpanel"
                            aria-labelledby="pills-home-tab-dealer">
                            <form id="sellerTermsForm">
                            <div class="d-flex border-bottom align-items-center mb-3">
                                <h6 class="flex-grow-1 text-start">Terms & Conditions</h6>
                                <input type="hidden" name="type" value="2">

                                <!-- <a class="table-button eyebox mb-2" type="button" data-bs-toggle="modal"
                                    data-bs-target="#editModal">
                                    <i class="bi bi-pencil-square"></i>
                                </a> -->
                            </div>

                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>English</h6>
                                        <!-- <a class="table-button eyebox mb-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a> -->
                                    </div>
                                    <div class="editor-wapper mt-2">
                                        <div class="editor">
                                            <textarea id="content_english_seller" name="content_english_seller"
                                                class="ckeditorfile" rowspan="5">
                                                {!! $sellerterms->content_english ?? '' !!}
                                            </textarea>
                                        </div>
                                        <span class="error-text text-danger" id="error_content_english_seller"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>Arabic</h6>
                                        <!-- <a class="table-button eyebox mb-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a> -->
                                    </div>
                                    <div class="editor-wapper mt-2">
                                        <div class="editor">
                                            <textarea id="content_arabic_seller" name="content_arabic_seller"
                                                class="ckeditorfile">
                                            {!! $sellerterms->content_arabic ?? '' !!}   
                                        </textarea>
                                        </div>
                                        <span class="error-text text-danger" id="error_content_arabic_seller"></span>
                                    </div>
                                </div>
                            </div>
                            @if(in_array(24, $permissions) || $admin->type == 1)
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn customBtn2 active text-white">
                                    Submit
                                </button>
                            </div>
                            @endif

                        </form>
                        </div>

                    <!-- Privacy Policy -->
                   
                        <div class="tab-pane fade" id="pills-privacy-dealer" role="tabpanel"
                            aria-labelledby="pills-privacy-tab-dealer">
                            <form id="sellerReturnForm">
                            <div class="d-flex border-bottom align-items-center mb-3">
                                <h6 class="flex-grow-1 text-start">Retrun Policy</h6>

                            </div>
                            <input type="hidden" name="type" value="2">

                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>English</h6>
                                        <!-- <a class="table-button eyebox mb-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a> -->
                                    </div>
                                    <div class="editor-wapper mt-2">
                                        <div class="editor">
                                            <textarea name="content_english_return_seller"
                                                id="content_english_return_seller" class="ckeditorfile" rowspan="5">
                                                {!! $sellerreturn->content_english ?? '' !!}
                                            </textarea>
                                        </div>
                                        <span class="error-text text-danger" id="error_content_english_return_seller"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>Arabic</h6>
                                        <!-- <a class="table-button eyebox mb-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a> -->
                                    </div>
                                    <div class="editor-wapper mt-2">
                                        <div class="editor">
                                            <textarea name="content_arabic_return_seller"
                                                id="content_arabic_return_seller" class="ckeditorfile">
                                                {!! $sellerreturn->content_arabic ?? '' !!}
                                            </textarea>
                                        </div>
                                        <span class="error-text text-danger" id="error_content_arabic_return_seller"></span>
                                    </div>
                                </div>
                            </div>
                            @if(in_array(24, $permissions) || $admin->type == 1)
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn customBtn2 active text-white">
                                    Submit
                                </button>
                            </div>
                            @endif
                        </form>
                        </div>

                    <!-- About Us -->
                   
                        <div class="tab-pane fade" id="pills-about-dealer" role="tabpanel"
                            aria-labelledby="pills-about-tab-dealer">
                            <form id="sellerAboutForm">
                            <div class="d-flex border-bottom align-items-center mb-3">
                                <h6 class="flex-grow-1 text-start">About Us</h6>

                            </div>
                            <input type="hidden" name="type" value="2">
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>English</h6>
                                        <!-- <a class="table-button eyebox mb-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a> -->
                                    </div>
                                    <div class="editor-wapper mt-2">
                                        <div class="editor">
                                            <textarea name="content_english_about_seller"
                                                id="content_english_about_seller" class="ckeditorfile" rowspan="5">
                                                {!! $sellerabout->content_english ?? '' !!}
                                            </textarea>
                                        </div>
                                        <span class="error-text text-danger" id="error_content_english_about_seller"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>Arabic</h6>
                                        <!-- <a class="table-button eyebox mb-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a> -->
                                    </div>
                                    <div class="editor-wapper mt-2">
                                        <div class="editor">
                                            <textarea name="content_arabic_about_seller"
                                                id="content_arabic_about_seller" class="ckeditorfile">
                                                {!! $sellerabout->content_arabic ?? '' !!}
                                            </textarea>
                                        </div>
                                        <span class="error-text text-danger" id="error_content_arabic_about_seller"></span>
                                    </div>
                                </div>
                            </div>
                            @if(in_array(24, $permissions) || $admin->type == 1)
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn customBtn2 active text-white">
                                    Submit
                                </button>
                            </div>
                            @endif
                        </form>
                        </div>
                    <!-- cancel-policy -->
                   
                        <div class="tab-pane fade" id="pills-cancel-dealer" role="tabpanel"
                            aria-labelledby="pills-cancel-tab-dealer">
                            <form id="sellerCancellationForm">
                            <div class="d-flex border-bottom align-items-center mb-3">
                                <h6 class="flex-grow-1 text-start">Cancellation Policy</h6>
                            </div>
                            <input type="hidden" name="type" value="2">
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>English</h6>
                                        <!-- <a class="table-button eyebox mb-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a> -->
                                    </div>
                                    <div class="editor-wapper mt-2">
                                        <div class="editor">
                                            <textarea name="content_english_cancellation_seller"
                                                id="content_english_cancellation_seller" class="ckeditorfile"
                                                rowspan="5">
                                            {!! $sellercancellation->content_english ?? '' !!}
                                        </textarea>
                                        </div>
                                        <span class="error-text text-danger" id="error_content_english_cancellation_seller"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>Arabic</h6>
                                        <!-- <a class="table-button eyebox mb-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a> -->
                                    </div>
                                    <div class="editor-wapper mt-2">
                                        <div class="editor">
                                            <textarea name="content_arabic_cancellation_seller"
                                                id="content_arabic_cancellation_seller" class="ckeditorfile">
                                            {!! $sellercancellation->content_arabic ?? '' !!}
                                        </textarea>
                                        </div>
                                        <span class="error-text text-danger" id="error_content_arabic_cancellation_seller"></span>
                                    </div>
                                </div>
                            </div>
                            @if(in_array(24, $permissions) || $admin->type == 1)
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn customBtn2 active text-white">
                                    Submit
                                </button>
                            </div>
                            @endif
                        </form>
                        </div>

                    <!-- exchange-policy -->
                   
                        <div class="tab-pane fade" id="pills-exchange-dealer" role="tabpanel"
                            aria-labelledby="pills-exchange-tab-dealer">
                            <form id="sellerExchangeForm">
                            <div class="d-flex border-bottom align-items-center mb-3">
                                <h6 class="flex-grow-1 text-start">Exchange Policy</h6>

                                <!-- <a class="table-button eyebox mb-2" type="button" data-bs-toggle="modal"
                                data-bs-target="#editModalAbout">
                                <i class="bi bi-pencil-square"></i>
                            </a> -->

                            </div>
                            <input type="hidden" name="type" value="2">
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>English</h6>
                                        <!-- <a class="table-button eyebox mb-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a> -->
                                    </div>
                                    <div class="editor-wapper mt-2">
                                        <div class="editor">
                                            <textarea name="content_english_exchange_seller"
                                                id="content_english_exchange_seller" class="ckeditorfile" rowspan="5">
                                            {!! $sellerexchange->content_english ?? '' !!}
                                        </textarea>
                                        </div>
                                        <span class="error-text text-danger" id="error_content_english_exchange_seller"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>Arabic</h6>
                                        <!-- <a class="table-button eyebox mb-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a> -->
                                    </div>
                                    <div class="editor-wapper mt-2">
                                        <div class="editor">
                                            <textarea name="content_arabic_exchange_seller"
                                                id="content_arabic_exchange_seller" class="ckeditorfile">
                                            {!! $sellerexchange->content_arabic ?? '' !!}
                                        </textarea>
                                        </div>
                                        <span class="error-text text-danger" id="error_content_arabic_exchange_seller"></span>
                                    </div>
                                </div>
                            </div>
                            @if(in_array(24, $permissions) || $admin->type == 1)
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn customBtn2 active text-white">
                                    Submit
                                </button>
                            </div>
                            @endif
                        </form>
                        </div>

                    <!-- FAQs -->
                    <div class="tab-pane fade" id="pills-faq-dealer" role="tabpanel"
                        aria-labelledby="pills-faq-tab-dealer">
                        <div class="d-flex border-bottom align-items-center mb-3">
                            <h5 class="flex-grow-1 text-start">FAQs</h5>
                            @if(in_array(24, $permissions) || $admin->type == 1)
                            <a class="btn btn-dark customBtn mb-2" type="button" data-bs-toggle="modal"
                                data-bs-target="#faqquestionModalSeller">Add New Question</a>
                            @endif
                        </div>
                        <div class="management mt-4 pb-5">
                            <h6>List of Questions(English)</h6>

                            <div class="faq-list-panle">
                                @forelse($sellerfaq as $index => $faq)
                                <div class="faq-english mb-3">
                                    <div class="form-grid">

                                        <div class="form-label">
                                            Question {{ $index + 1 }} (English)
                                        </div>
                                        <div class="form-text">
                                            {!! $faq->question_english ?? '' !!}
                                        </div>

                                        <div class="form-label">Answer (English)</div>
                                        <div class="form-text">
                                            {!! $faq->answer_english ?? '' !!}
                                        </div>

                                        <div class="form-label">
                                            Question {{ $index + 1 }} (Arabic)
                                        </div>
                                        <div class="form-text">
                                            {!! $faq->question_arabic ?? '' !!}
                                        </div>

                                        <div class="form-label">Answer (Arabic)</div>
                                        <div class="form-text">
                                            {!! $faq->answer_arabic ?? '' !!}
                                        </div>

                                    </div>
                                       @if(in_array(24, $permissions) || $admin->type == 1)
                                        <div class="d-flex gap-3 justify-content-end align-items-center">
                                            <a class="table-button editFaqBtnSeller"
                                                href="javascript:void(0)"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editFaqSellerModal"
                                                data-id="{{ $faq->id }}"
                                                data-qe="{{ $faq->question_english }}"
                                                data-ae="{{ $faq->answer_english }}"
                                                data-qa="{{ $faq->question_arabic }}"
                                                data-aa="{{ $faq->answer_arabic }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a href="javascript:void(0);"
                                            class="table-button text-danger deleteFaq mb-1 mt-1"
                                            data-id="{{ $faq->id }}">
                                            <i class="bi bi-trash3-fill"></i>
                                            </a>
                                        </div>
                                        @endif
                                </div>
                                @empty
                                <div class="text-center text-muted">
                                    No FAQs found.
                                </div>
                                @endforelse
                            </div>


                        </div>
                    </div>

                    <!-- Contact Us -->
                    <div class="tab-pane fade" id="pills-contact-dealer" role="tabpanel"
                        aria-labelledby="pills-contact-tab-dealer">

                        <div class="d-flex border-bottom align-items-center mb-3">
                            <h5 class="flex-grow-1 text-start">Contact Us</h5>
                        </div>

                        <input type="hidden" value="2" name="type" />

                        <div class="contactUs mx-auto" style="max-width: 400px">

                            <div class="form-group mb-2">
                                <label class="form-label" for="email">Email id</label>
                                <input type="text" id="email_seller" class="form-control space" name="email_seller"
                                    placeholder="Enter Email"
                                    value="{{ $sellerContactUs->content_english['email'] ?? '' }}" />
                                <h6 class="text-danger error-email_seller"></h6>
                            </div>

                            <div class="form-group mb-2">
                                <label class="form-label space" for="phone">Contact Number</label>
                                <input type="tel" id="mobile_seller" class="form-control space" name="mobile_seller"
                                    placeholder="Enter Mobile Number"
                                    oninput="this.value = this.value.replace(/[^0-9+]/g,'')"
                                    value="{{ $sellerContactUs->content_english['mobile'] ?? '' }}" />
                                <h6 class="text-danger error-mobile_seller"></h6>
                            </div>

                            <div class="form-group mb-2">
                                <label class="form-label space" for="twitter">Whatsapp Number</label>
                                <input type="text" id="whatsapp_seller" class="form-control" name="whatsapp_seller"
                                    placeholder="Enter Whatsapp Number"
                                    oninput="this.value = this.value.replace(/[^0-9+]/g,'')"
                                    value="{{ $sellerContactUs->content_english['whatsapp'] ?? '' }}" />
                                <h6 class="text-danger error-whatsapp_seller"></h6>
                            </div>
                            @if(in_array(24, $permissions) || $admin->type == 1)
                            <div class="d-flex justify-content-center mt-3">
                                <button type="button" id="contactSubmitBtnSeller" class="btn btn-dark customBtn">
                                    <span>Submit</span>
                                </button>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

            <!-- Delivery Boy -->
            <div class="tab-pane fade show " id="deliveryboy" role="tabpanel" aria-labelledby="user-tab">
                <!-- Inner Tabs for CMS -->
                <div class="d-flex justify-content-center mb-3">
                    <ul class="nav nav-pills tabs-pnl custom" id="driverCmsTab" role="tablist">
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 active m-0" id="pills-home3-tab-driver"
                                data-bs-toggle="pill" data-bs-target="#pills-home3-driver" type="button" role="tab"
                                aria-controls="pills-home3-driver" aria-selected="true">
                                Terms & Conditions
                            </button>
                        </li>

                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 m-0" id="pills-privacy3-tab-driver" data-bs-toggle="pill"
                                data-bs-target="#pills-privacy3-driver" type="button" role="tab"
                                aria-controls="pills-privacy3-driver" aria-selected="false">
                                Return Policy
                            </button>
                        </li>
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 m-0" id="pills-about3-tab-driver" data-bs-toggle="pill"
                                data-bs-target="#pills-about3-driver" type="button" role="tab"
                                aria-controls="pills-about3-driver" aria-selected="false">
                                About Us
                            </button>
                        </li>
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 m-0" id="pills-cancel3-tab-driver" data-bs-toggle="pill"
                                data-bs-target="#pills-cancel3-driver" type="button" role="tab"
                                aria-controls="pills-cancel3-driver" aria-selected="false">
                                Cancellation Policy
                            </button>
                        </li>
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 m-0" id="pills-exchange3-tab-driver" data-bs-toggle="pill"
                                data-bs-target="#pills-exchange3-driver" type="button" role="tab"
                                aria-controls="pills-exchange3-driver" aria-selected="false">
                                Exchange Policy
                            </button>
                        </li>
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 m-0" id="pills-faq3-tab-driver" data-bs-toggle="pill"
                                data-bs-target="#pills-faq3-driver" type="button" role="tab" aria-controls="pills-faq3-driver"
                                aria-selected="false">
                                FAQs
                            </button>
                        </li>
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 m-0" id="pills-contact3-tab-driver" data-bs-toggle="pill"
                                data-bs-target="#pills-contact3-driver" type="button" role="tab"
                                aria-controls="pills-contact3-driver" aria-selected="false">
                                Contact Us
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- User CMS Tab Content -->

                <div class="tab-content" id="deliveryboy">
                    <!-- Terms & Conditions -->
                        <div class="tab-pane fade show active" id="pills-home3-driver" role="tabpanel"
                            aria-labelledby="pills-home3-tab-driver">
                            <form id="driverTermsForm">
                            <div class="d-flex border-bottom align-items-center mb-3">
                                <h6 class="flex-grow-1 text-start">Terms & Conditions</h6>
                                <input type="hidden" name="type" value="3">

                                <!-- <a class="table-button eyebox mb-2" type="button" data-bs-toggle="modal"
                                    data-bs-target="#editModal">
                                    <i class="bi bi-pencil-square"></i>
                                </a> -->
                            </div>

                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>English</h6>
                                        <!-- <a class="table-button eyebox mb-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a> -->
                                    </div>
                                    <div class="editor-wapper mt-2">
                                        <div class="editor">
                                            <textarea id="content_english_driver" name="content_english_driver" class="ckeditorfile"
                                                rowspan="5">
                                                {!! $driverterms->content_english ?? '' !!}
                                            </textarea>
                                        </div>
                                        <span class="error-text text-danger" id="error_content_english_driver"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>Arabic</h6>
                                        <!-- <a class="table-button eyebox mb-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a> -->
                                    </div>
                                    <div class="editor-wapper mt-2">
                                        <div class="editor">
                                            <textarea id="content_arabic_driver" name="content_arabic_driver" class="ckeditorfile">
                                            {!! $driverterms->content_arabic ?? '' !!}   
                                        </textarea>
                                        </div>
                                        <span class="error-text text-danger" id="error_content_arabic_driver"></span>
                                    </div>
                                </div>
                            </div>
                            @if(in_array(24, $permissions) || $admin->type == 1)
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn customBtn2 active text-white">
                                    Submit
                                </button>
                            </div>
                            @endif

                        </form>
                        </div>

                    <!-- Privacy Policy -->
                    
                        <div class="tab-pane fade" id="pills-privacy3-driver" role="tabpanel"
                            aria-labelledby="pills-privacy3-tab-driver">
                            <form id="driverReturnForm">
                            <div class="d-flex border-bottom align-items-center mb-3">
                                <h6 class="flex-grow-1 text-start">Retrun Policy</h6>

                            </div>
                            <input type="hidden" name="type" value="3">

                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>English</h6>
                                        <!-- <a class="table-button eyebox mb-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a> -->
                                    </div>
                                    <div class="editor-wapper mt-2">
                                        <div class="editor">
                                            <textarea name="content_english_return_driver" id="content_english_return_driver"
                                                class="ckeditorfile" rowspan="5">
                                                {!! $driverreturn->content_english ?? '' !!}
                                            </textarea>
                                        </div>
                                        <span class="error-text text-danger" id="error_content_english_return_driver"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>Arabic</h6>
                                        <!-- <a class="table-button eyebox mb-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a> -->
                                    </div>
                                    <div class="editor-wapper mt-2">
                                        <div class="editor">
                                            <textarea name="content_arabic_return_driver" id="content_arabic_return_driver"
                                                class="ckeditorfile">
                                                {!! $driverreturn->content_arabic ?? '' !!}
                                            </textarea>
                                        </div>
                                        <span class="error-text text-danger" id="error_content_arabic_return_driver"></span>
                                    </div>
                                </div>
                            </div>
                            @if(in_array(24, $permissions) || $admin->type == 1)
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn customBtn2 active text-white">
                                    Submit
                                </button>
                            </div>
                            @endif
                        </form>
                        </div>

                    <!-- About Us -->
                  
                        <div class="tab-pane fade" id="pills-about3-driver" role="tabpanel"
                            aria-labelledby="pills-about3-tab-driver">
                            <form id="driverAboutForm">
                            <div class="d-flex border-bottom align-items-center mb-3">
                                <h6 class="flex-grow-1 text-start">About Us</h6>

                            </div>
                            <input type="hidden" name="type" value="3">
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>English</h6>
                                        <!-- <a class="table-button eyebox mb-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a> -->
                                    </div>
                                    <div class="editor-wapper mt-2">
                                        <div class="editor">
                                            <textarea name="content_english_about_driver" id="content_english_about_driver"
                                                class="ckeditorfile" rowspan="5">
                                                {!! $driverabout->content_english ?? '' !!}
                                            </textarea>
                                        </div>
                                        <span class="error-text text-danger" id="error_content_english_about_driver"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>Arabic</h6>
                                        <!-- <a class="table-button eyebox mb-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a> -->
                                    </div>
                                    <div class="editor-wapper mt-2">
                                        <div class="editor">
                                            <textarea name="content_arabic_about_driver" id="content_arabic_about_driver"
                                                class="ckeditorfile">
                                                {!! $driverabout->content_arabic ?? '' !!}
                                            </textarea>
                                        </div>
                                        <span class="error-text text-danger" id="error_content_arabic_about_driver"></span>
                                    </div>
                                </div>
                            </div>
                            @if(in_array(24, $permissions) || $admin->type == 1)
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn customBtn2 active text-white">
                                    Submit
                                </button>
                            </div>
                            @endif
                        </form>
                        </div>
                    <!-- cancel-policy -->
                    
                        <div class="tab-pane fade" id="pills-cancel3-driver" role="tabpanel"
                            aria-labelledby="pills-cancel3-tab-driver">
                            <form id="driverCancellationForm">
                            <div class="d-flex border-bottom align-items-center mb-3">
                                <h6 class="flex-grow-1 text-start">Cancellation Policy</h6>
                            </div>
                            <input type="hidden" name="type" value="3">
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>English</h6>
                                        <!-- <a class="table-button eyebox mb-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a> -->
                                    </div>
                                    <div class="editor-wapper mt-2">
                                        <div class="editor">
                                            <textarea name="content_english_cancellation_driver"
                                                id="content_english_cancellation_driver" class="ckeditorfile" rowspan="5">
                                            {!! $drivercancellation->content_english ?? '' !!}
                                        </textarea>
                                        </div>
                                        <span class="error-text text-danger" id="error_content_english_cancellation_driver"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>Arabic</h6>
                                        <!-- <a class="table-button eyebox mb-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a> -->
                                    </div>
                                    <div class="editor-wapper mt-2">
                                        <div class="editor">
                                            <textarea name="content_arabic_cancellation_driver"
                                                id="content_arabic_cancellation_driver" class="ckeditorfile">
                                            {!! $drivercancellation->content_arabic ?? '' !!}
                                        </textarea>
                                        </div>
                                        <span class="error-text text-danger" id="error_content_arabic_cancellation_driver"></span>
                                    </div>
                                </div>
                            </div>
                            @if(in_array(24, $permissions) || $admin->type == 1)
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn customBtn2 active text-white">
                                    Submit
                                </button>
                            </div>
                            @endif
                        </form>
                        </div>

                    <!-- exchange-policy -->
                   
                        <div class="tab-pane fade" id="pills-exchange3-driver" role="tabpanel"
                            aria-labelledby="pills-exchange3-tab-driver">
                            <form id="driverExchangeForm">
                            <div class="d-flex border-bottom align-items-center mb-3">
                                <h6 class="flex-grow-1 text-start">Exchange Policy</h6>

                                <!-- <a class="table-button eyebox mb-2" type="button" data-bs-toggle="modal"
                                data-bs-target="#editModalAbout">
                                <i class="bi bi-pencil-square"></i>
                            </a> -->

                            </div>
                            <input type="hidden" name="type" value="3">
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>English</h6>
                                        <!-- <a class="table-button eyebox mb-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a> -->
                                    </div>
                                    <div class="editor-wapper mt-2">
                                        <div class="editor">
                                            <textarea name="content_english_exchange_driver" id="content_english_exchange_driver"
                                                class="ckeditorfile" rowspan="5">
                                            {!! $driverexchange->content_english ?? '' !!}
                                        </textarea>
                                        </div>
                                        <span class="error-text text-danger" id="error_content_english_exchange_driver"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6>Arabic</h6>
                                        <!-- <a class="table-button eyebox mb-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a> -->
                                    </div>
                                    <div class="editor-wapper mt-2">
                                        <div class="editor">
                                            <textarea name="content_arabic_exchange_driver" id="content_arabic_exchange_driver"
                                                class="ckeditorfile">
                                            {!! $driverexchange->content_arabic ?? '' !!}
                                        </textarea>
                                        </div>
                                        <span class="error-text text-danger" id="error_content_arabic_exchange_driver"></span>
                                    </div>
                                </div>
                            </div>
                            @if(in_array(24, $permissions) || $admin->type == 1)
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn customBtn2 active text-white">
                                    Submit
                                </button>
                            </div>
                            @endif
                        </form>
                        </div>

                    <!-- FAQs -->
                    <div class="tab-pane fade" id="pills-faq3-driver" role="tabpanel" aria-labelledby="pills-faq3-tab-driver">
                        <div class="d-flex border-bottom align-items-center mb-3">
                            <h5 class="flex-grow-1 text-start">FAQs</h5>
                            <a class="btn btn-dark customBtn mb-2" type="button" data-bs-toggle="modal"
                                data-bs-target="#faqquestionModalDriver">Add New Question</a>
                        </div>
                        <div class="management mt-4 pb-5">
                            <h6>List of Questions(English)</h6>

                            <div class="faq-list-panle mb-5">
                                @forelse($driverfaq as $index => $faq)
                                <div class="faq-english mb-3">
                                    <div class="form-grid">

                                        <div class="form-label">
                                            Question {{ $index + 1 }} (English)
                                        </div>
                                        <div class="form-text">
                                            {!! $faq->question_english ?? '' !!}
                                        </div>

                                        <div class="form-label">Answer (English)</div>
                                        <div class="form-text">
                                            {!! $faq->answer_english ?? '' !!}
                                        </div>

                                        <div class="form-label">
                                            Question {{ $index + 1 }} (Arabic)
                                        </div>
                                        <div class="form-text">
                                            {!! $faq->question_arabic ?? '' !!}
                                        </div>

                                        <div class="form-label">Answer (Arabic)</div>
                                        <div class="form-text">
                                            {!! $faq->answer_arabic ?? '' !!}
                                        </div>

                                    </div>
                                    @if(in_array(24, $permissions) || $admin->type == 1)
                                    <div class="d-flex gap-3 justify-content-end align-items-center">
                                            <a class="table-button editFaqBtnDriver"
                                                href="javascript:void(0)"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editFaqDriverModal"
                                                data-id="{{ $faq->id }}"
                                                data-qe="{{ $faq->question_english }}"
                                                data-ae="{{ $faq->answer_english }}"
                                                data-qa="{{ $faq->question_arabic }}"
                                                data-aa="{{ $faq->answer_arabic }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a href="javascript:void(0);"
                                            class="table-button text-danger deleteFaq mb-1 mt-1"
                                            data-id="{{ $faq->id }}">
                                            <i class="bi bi-trash3-fill"></i>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                @empty
                                <div class="text-center text-muted">
                                    No FAQs found.
                                </div>
                                @endforelse
                            </div>


                        </div>
                    </div>

                    
                    <div class="tab-pane fade" id="pills-contact3-driver" role="tabpanel"
                        aria-labelledby="pills-contact3-tab-driver">

                        <div class="d-flex border-bottom align-items-center mb-3">
                            <h5 class="flex-grow-1 text-start">Contact Us</h5>
                        </div>

                        <input type="hidden" value="3" name="type" />

                        <div class="contactUs mx-auto" style="max-width: 400px">

                            <div class="form-group mb-2">
                                <label class="form-label" for="email">Email id</label>
                                <input type="text" id="email_driver" class="form-control space" name="email"
                                    placeholder="Enter Email"
                                    value="{{ $driverContactUs->content_english['email'] ?? '' }}" />
                                <h6 class="text-danger error-email_driver"></h6>
                            </div>

                            <div class="form-group mb-2">
                                <label class="form-label space" for="phone">Contact Number</label>
                                <input type="tel" id="mobile_driver" class="form-control space" name="mobile"
                                    placeholder="Enter Mobile Number"
                                    oninput="this.value = this.value.replace(/[^0-9+]/g,'')"
                                    value="{{ $driverContactUs->content_english['mobile'] ?? '' }}" />
                                <h6 class="text-danger error-mobile_driver"></h6>
                            </div>

                            <div class="form-group mb-2">
                                <label class="form-label space" for="twitter">Whatsapp Number</label>
                                <input type="text" id="whatsapp_driver" class="form-control" name="whatsapp"
                                    placeholder="Enter Whatsapp Number"
                                    oninput="this.value = this.value.replace(/[^0-9+]/g,'')"
                                    value="{{ $driverContactUs->content_english['whatsapp'] ?? '' }}" />
                                <h6 class="text-danger error-whatsapp_driver"></h6>
                            </div>
                            @if(in_array(24, $permissions) || $admin->type == 1)
                            <div class="d-flex justify-content-center mt-3">
                                <button type="button" id="contactSubmitBtnDriver" class="btn btn-dark customBtn">
                                    <span>Submit</span>
                                </button>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>




<!-- add faq Question user -->
<div class="modal fade" id="faqquestionModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header border-0">
                <h3 class="modal-title">Add FAQ USER</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="form-group">

                    <label>Question English</label>
                    <input id="question_english" class="form-control mb-2" type="text"
                        placeholder="Enter Question in English"
                        oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')">
                    <h6 class="text-danger error-question_english"></h6>

                    <label>Answer English</label>
                    <textarea id="answer_english" class="form-control mb-2" placeholder="Enter Answer in English"
                        oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')"></textarea>
                    <h6 class="text-danger error-answer_english"></h6>

                    <label>Question Arabic</label>
                    <input id="question_arabic" dir="rtl" style="text-align: right;" class="form-control mb-2" type="text"
                        placeholder="Enter Question in Arabic"
                        oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')">
                    <h6 class="text-danger error-question_arabic"></h6>

                    <label>Answer Arabic</label>
                    <textarea id="answer_arabic" dir="rtl" style="text-align: right;" class="form-control mb-2" placeholder="Enter Answer in Arabic"
                        oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')"></textarea>
                    <h6 class="text-danger error-answer_arabic"></h6>

                    <input type="hidden" id="type_user" value="1">

                    <div class="text-center mt-3">
                        <button type="button" id="addFaqBtn" class="btn customBtn2 active text-white">
                            <span>Add</span>
                        </button>
                        
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- add faq Question seller -->
<div class="modal fade" id="faqquestionModalSeller" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header border-0">
                <h3 class="modal-title">Add FAQ SELLER</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="form-group">

                    <label>Question English</label>
                    <input id="question_english_seller" class="form-control mb-2" type="text"
                        placeholder="Enter Question in English"
                        oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')">
                    <h6 class="text-danger error-question_english_seller"></h6>

                    <label>Answer English</label>
                    <textarea id="answer_english_seller" class="form-control mb-2" placeholder="Enter Answer in English"
                        oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')"></textarea>
                    <h6 class="text-danger error-answer_english_seller"></h6>

                    <label>Question Arabic</label>
                    <input id="question_arabic_seller" dir="rtl" style="text-align: right;" class="form-control mb-2" type="text"
                        placeholder="Enter Question in Arabic"
                        oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')">
                    <h6 class="text-danger error-question_arabic_seller"></h6>

                    <label>Answer Arabic</label>
                    <textarea id="answer_arabic_seller" dir="rtl" style="text-align: right;" class="form-control mb-2" placeholder="Enter Answer in Arabic"
                        oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')"></textarea>
                    <h6 class="text-danger error-answer_arabic_seller"></h6>

                    <input type="hidden" id="type_seller" value="2">

                    <div class="text-center mt-3">
                        <button type="button" id="addFaqBtnSeller" class="btn customBtn2 active text-white">
                            <span>Add</span>
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- add faq Question driver -->
<div class="modal fade" id="faqquestionModalDriver" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header border-0">
                <h3 class="modal-title">Add FAQ DELIVERY BOY</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="form-group">

                    <label>Question English</label>
                    <input id="question_english_driver" class="form-control mb-2" type="text"
                        placeholder="Enter Question in English"
                        oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')">
                    <h6 class="text-danger error-question_english_driver"></h6>

                    <label>Answer English</label>
                    <textarea id="answer_english_driver" class="form-control mb-2" placeholder="Enter Answer in English"
                        oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')"></textarea>
                    <h6 class="text-danger error-answer_english_driver"></h6>

                    <label>Question Arabic</label>
                    <input id="question_arabic_driver" dir="rtl" style="text-align: right;" class="form-control mb-2" type="text"
                        placeholder="Enter Question in Arabic"
                        oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')">
                    <h6 class="text-danger error-question_arabic_driver"></h6>

                    <label>Answer Arabic</label>
                    <textarea id="answer_arabic_driver" dir="rtl" style="text-align: right;" class="form-control mb-2" placeholder="Enter Answer in Arabic"
                        oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')"></textarea>
                    <h6 class="text-danger error-answer_arabic_driver"></h6>

                    <input type="hidden" id="type_driver" value="3">

                    <div class="text-center mt-3">
                        <button type="button" id="addFaqBtnDriver" class="btn customBtn2 active text-white">
                            <span>Add</span>
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- edit faq user-->
<div class="modal fade" id="editFaqUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header border-0">
                <h3 class="modal-title">Edit FAQ USER</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="form-group">

                    <!-- hidden id -->
                    <input type="hidden" id="edit_faq_id">

                    <label>Question English</label>
                    <input id="edit_question_english" class="form-control mb-2" type="text"
                        placeholder="Enter Question in English" oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')">
                    <h6 class="text-danger error-edit_question_english"></h6>

                    <label>Answer English</label>
                    <textarea id="edit_answer_english" class="form-control mb-2"
                        placeholder="Enter Answer in English" oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')"></textarea>
                    <h6 class="text-danger error-edit_answer_english"></h6>

                    <label>Question Arabic</label>
                    <input id="edit_question_arabic" dir="rtl" style="text-align: right;" class="form-control mb-2" type="text"
                        placeholder="Enter Question in Arabic" oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')">
                    <h6 class="text-danger error-edit_question_arabic"></h6>

                    <label>Answer Arabic</label>
                    <textarea id="edit_answer_arabic" dir="rtl" style="text-align: right;" class="form-control mb-2"
                        placeholder="Enter Answer in Arabic" oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')"></textarea>
                    <h6 class="text-danger error-edit_answer_arabic"></h6>

                    <div class="text-center mt-3">
                        <button type="button" id="updateFaqBtn"
                            class="btn customBtn2 active text-white">
                            <span>Update</span>
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- edit faq seller -->
<div class="modal fade" id="editFaqSellerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header border-0">
                <h3 class="modal-title">Edit FAQ SELLER</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="form-group">

                    <input type="hidden" id="edit_faq_id_seller">

                    <label>Question English</label>
                    <input id="edit_question_english_seller" class="form-control mb-2" type="text"
                        placeholder="Enter Question in English" oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')">
                    <h6 class="text-danger error-edit_question_english_seller"></h6>

                    <label>Answer English</label>
                    <textarea id="edit_answer_english_seller" class="form-control mb-2"
                        placeholder="Enter Answer in English" oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')"></textarea>
                    <h6 class="text-danger error-edit_answer_english_seller"></h6>

                    <label>Question Arabic</label>
                    <input id="edit_question_arabic_seller" dir="rtl" style="text-align: right;" class="form-control mb-2" type="text"
                        placeholder="Enter Question in Arabic" oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')">
                    <h6 class="text-danger error-edit_question_arabic_seller"></h6>

                    <label>Answer Arabic</label>
                    <textarea id="edit_answer_arabic_seller" dir="rtl" style="text-align: right;" class="form-control mb-2"
                        placeholder="Enter Answer in Arabic" oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')"></textarea>
                    <h6 class="text-danger error-edit_answer_arabic_seller"></h6>

                    <div class="text-center mt-3">
                        <button type="button" id="updateFaqBtnSeller"
                            class="btn customBtn2 active text-white">
                            <span>Update</span>
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- edit faq driver -->
<div class="modal fade" id="editFaqDriverModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header border-0">
                <h3 class="modal-title">Edit FAQ DRIVER</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="form-group">

                    <input type="hidden" id="edit_faq_id_driver">

                    <label>Question English</label>
                    <input id="edit_question_english_driver" class="form-control mb-2" type="text"
                        placeholder="Enter Question in English" oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')">
                    <h6 class="text-danger error-edit_question_english_driver"></h6>

                    <label>Answer English</label>
                    <textarea id="edit_answer_english_driver" class="form-control mb-2"
                        placeholder="Enter Answer in English" oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')"></textarea>
                    <h6 class="text-danger error-edit_answer_english_driver"></h6>

                    <label>Question Arabic</label>
                    <input id="edit_question_arabic_driver" dir="rtl" style="text-align: right;" class="form-control mb-2" type="text"
                        placeholder="Enter Question in Arabic" oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')"></input>
                    <h6 class="text-danger error-edit_question_arabic_driver"></h6>

                    <label>Answer Arabic</label>
                    <textarea id="edit_answer_arabic_driver" dir="rtl" style="text-align: right;" class="form-control mb-2"
                        placeholder="Enter Answer in Arabic" oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')"></textarea>
                    <h6 class="text-danger error-edit_answer_arabic_driver"></h6>

                    <div class="text-center mt-3">
                        <button type="button" id="updateFaqBtnDriver"
                            class="btn customBtn2 active text-white">
                            <span>Update</span>
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>






<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// document.addEventListener("DOMContentLoaded", function() {
//     //get active tab from local storage
//     const lastTab = localStorage.getItem("activeTab");
//     if (lastTab) {
//         const triggerEl = document.querySelector(`#${lastTab}`);
//         if (triggerEl) {
//             const tab = new bootstrap.Tab(triggerEl);
//             tab.show();
//         }
//     }
//     //save active tab to local storage
//     const tabButtons = document.querySelectorAll('button[data-bs-toggle="pill"]');
//     tabButtons.forEach((button) => {
//         button.addEventListener("shown.bs.tab", function() {
//             localStorage.setItem("activeTab", this.id);
//         });
//     });
// });
document.addEventListener("DOMContentLoaded", function() {
    const tabContentContainer = document.getElementById('tabContentContainer');

    // 1️⃣ Restore last active tab on page load
    const lastTab = localStorage.getItem("activeTab");
    if (lastTab) {
        const triggerEl = document.querySelector(`#${lastTab}`);
        if (triggerEl) {
            const tab = new bootstrap.Tab(triggerEl);
            tab.show(); // Show the saved tab immediately
        }
    }

    // 2️⃣ Show tab container after activating the saved tab
    if (tabContentContainer) {
        tabContentContainer.classList.add('active-shown');
    }

    // 3️⃣ Reload page when user clicks a different tab
    const tabButtons = document.querySelectorAll('button[data-bs-toggle="pill"]');
    tabButtons.forEach((button) => {
        button.addEventListener("click", function(e) {
            const currentTab = localStorage.getItem("activeTab");
            if (currentTab !== this.id) {
                e.preventDefault(); // Stop Bootstrap from switching tab immediately
                localStorage.setItem("activeTab", this.id);
                //location.reload(); // reload before tab content shows
            }
        });
    });
});
</script>

<!-- user tems & condition -->
<script>
let editors = {};

document.addEventListener("DOMContentLoaded", function() {
    // document.querySelectorAll('.ckeditorfile').forEach(function(element) {
    //     ClassicEditor
    //         .create(element)
    //         .then(editor => {
    //             editors[element.name] = editor;

    //             editor.model.document.on('change:data', function() {
    //                 let data = editor.getData().replace(/<[^>]*>/g, '').trim();

    //                 if (data) {
    //                     $('#error_' + element.name).text('');
    //                 }
    //             });
    //         })
    //         .catch(error => console.error(error));
    // });
    document.querySelectorAll('.ckeditorfile').forEach(function(element) {
        ClassicEditor
            .create(element, {
                language: {
                    content: element.name.includes('arabic') ? 'ar' : 'en'
                }, 
                toolbar: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'undo',
                    'redo'
                ]
            })
            .then(editor => {
                // Store the editor instance using the element's name as key
                editors[element.name] = editor;

                // If the field is Arabic, apply RTL direction inside the editor
                if (element.name.includes('arabic')) {
                    editor.editing.view.change(writer => {
                        writer.setAttribute(
                            'dir',
                            'rtl',
                            editor.editing.view.document.getRoot()
                        );
                    });

                    // Optional: Filter out non-Arabic characters on data change (strict input)
                    editor.model.document.on('change:data', () => {
                        let data = editor.getData();
                        let plainText = data.replace(/<[^>]*>/g, '');
                        let filteredText = plainText.replace(/[^\u0600-\u06FF\s]/g, '');
                        if (plainText !== filteredText) {
                            editor.setData(filteredText);
                        }
                    });
                }

                // Remove validation error message when user starts typing (all editors)
                editor.model.document.on('change:data', function() {
                    let data = editor.getData().replace(/<[^>]*>/g, '').trim();
                    if (data) {
                        $('#error_' + element.name).text('');
                    }
                });
            })
            .catch(error => console.error(error)); 
    });

    $('#userTermsForm').on('submit', function(e) {
        e.preventDefault();

        let content_english = editors['content_english'] ? editors['content_english'].getData() : '';
        let content_arabic = editors['content_arabic'] ? editors['content_arabic'].getData() : '';

        let hasError = false;

        $('#error_content_english').text('');
        $('#error_content_arabic').text('');

        if (!content_english) {
            $('#error_content_english').text('Please enter content in English');
            hasError = true;
        }

        if (!content_arabic) {
            $('#error_content_arabic').text('Please enter content in Arabic');
            hasError = true;
        }

        if (hasError) return;

        $.ajax({
            url: "{{ route('admin.create_update_terms_condition') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                type: 1,
                content_english: content_english,
                content_arabic: content_arabic
            },
            success: function(response) {
                toastr.success(response.message);
                // setTimeout(function () {
                //     location.reload();
                // }, 1500); 
            },
            error: function(xhr) {
                let res = xhr.responseJSON;
                toastr.error(res?.message || 'Something went wrong');
            }
        });
    });

    $('#userReturnForm').on('submit', function(e) {
        e.preventDefault();

        let content_english_return = editors['content_english_return'] ? editors['content_english_return'].getData() : '';
        let content_arabic_return = editors['content_arabic_return'] ? editors['content_arabic_return'].getData() : '';

        let hasError = false;

        $('#error_content_english_return').text('');
        $('#error_content_arabic_return').text('');

        if (!content_english_return) {
            $('#error_content_english_return').text('Please enter content in English');
            hasError = true;
        }

        if (!content_arabic_return) {
            $('#error_content_arabic_return').text('Please enter content in Arabic');
            hasError = true;
        }

        if (hasError) return;

        $.ajax({
            url: "{{ route('admin.create_update_return_policy') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                type: 1,
                content_english: editors['content_english_return']?.getData() || '',
                content_arabic: editors['content_arabic_return']?.getData() || ''
            },
            success: function(response) {
                toastr.success(response.message);
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Something went wrong');
            }
        });
    });

    $('#userAboutForm').on('submit', function(e) {
        e.preventDefault();

         let content_english = editors['content_english_about'] ? editors['content_english_about'].getData() : '';
        let content_arabic = editors['content_arabic_about'] ? editors['content_arabic_about'].getData() : '';

        let hasError = false;

        $('#error_content_english_about').text('');
        $('#error_content_arabic_about').text('');

        if (!content_english) {
            $('#error_content_english_about').text('Please enter content in English');
            hasError = true;
        }

        if (!content_arabic) {
            $('#error_content_arabic_about').text('Please enter content in Arabic');
            hasError = true;
        }

        if (hasError) return;

        $.ajax({
            url: "{{ route('admin.create_update_about_us') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                type: 1,
                content_english: editors['content_english_about']?.getData() || '',
                content_arabic: editors['content_arabic_about']?.getData() || ''
            },
            success: function(response) {
                toastr.success(response.message);
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Something went wrong');
            }
        });
    });

    $('#userCancellationForm').on('submit', function(e) {
        e.preventDefault();

         let content_english = editors['content_english_cancellation'] ? editors['content_english_cancellation'].getData() : '';
        let content_arabic = editors['content_arabic_cancellation'] ? editors['content_arabic_cancellation'].getData() : '';

        let hasError = false;

        $('#error_content_english_cancellation').text('');
        $('#error_content_arabic_cancellation').text('');

        if (!content_english) {
            $('#error_content_english_cancellation').text('Please enter content in English');
            hasError = true;
        }

        if (!content_arabic) {
            $('#error_content_arabic_cancellation').text('Please enter content in Arabic');
            hasError = true;
        }

        if (hasError) return;

        $.ajax({
            url: "{{ route('admin.create_update_cancellation_policy') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                type: 1,
                content_english: editors['content_english_cancellation']?.getData() || '',
                content_arabic: editors['content_arabic_cancellation']?.getData() || ''
            },
            success: function(response) {
                toastr.success(response.message);
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Something went wrong');
            }
        });
    });

    $('#userExchangeForm').on('submit', function(e) {
        e.preventDefault();

        let content_english = editors['content_english_exchange'] ? editors['content_english_exchange'].getData() : '';
        let content_arabic = editors['content_arabic_exchange'] ? editors['content_arabic_exchange'].getData() : '';

        let hasError = false;

        $('#error_content_english_exchange').text('');
        $('#error_content_arabic_exchange').text('');

        if (!content_english) {
            $('#error_content_english_exchange').text('Please enter content in English');
            hasError = true;
        }

        if (!content_arabic) {
            $('#error_content_arabic_exchange').text('Please enter content in Arabic');
            hasError = true;
        }

        if (hasError) return;

        $.ajax({
            url: "{{ route('admin.create_update_exchange_policy') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                type: 1,
                content_english: editors['content_english_exchange']?.getData() || '',
                content_arabic: editors['content_arabic_exchange']?.getData() || ''
            },
            success: function(response) {
                toastr.success(response.message);
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Something went wrong');
            }
        });
    });
    //seller
    $('#sellerTermsForm').on('submit', function(e) {
        e.preventDefault();

        let content_english = editors['content_english_seller'] ? editors['content_english_seller']
            .getData() : '';
        let content_arabic = editors['content_arabic_seller'] ? editors['content_arabic_seller']
            .getData() : '';

        let hasError = false;

        $('#error_content_english_seller').text('');
        $('#error_content_arabic_seller').text('');

        if (!content_english) {
            $('#error_content_english_seller').text('Please enter content in English');
            hasError = true;
        }

        if (!content_arabic) {
            $('#error_content_arabic_seller').text('Please enter content in Arabic');
            hasError = true;
        }

        if (hasError) return;

        $.ajax({
            url: "{{ route('admin.create_update_terms_condition') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                type: 2,
                content_english: content_english,
                content_arabic: content_arabic
            },
            success: function(response) {
                toastr.success(response.message);
                // setTimeout(function () {
                //     location.reload();
                // }, 1500); 
            },
            error: function(xhr) {
                let res = xhr.responseJSON;
                toastr.error(res?.message || 'Something went wrong');
            }
        });
    });

    $('#sellerReturnForm').on('submit', function(e) {
        e.preventDefault();

        let content_english = editors['content_english_return_seller'] ? editors['content_english_return_seller'].getData() : '';
        let content_arabic = editors['content_arabic_return_seller'] ? editors['content_arabic_return_seller'].getData() : '';

        let hasError = false;

        $('#error_content_english_return_seller').text('');
        $('#error_content_arabic_return_seller').text('');

        if (!content_english) {
            $('#error_content_english_return_seller').text('Please enter content in English');
            hasError = true;
        }

        if (!content_arabic) {
            $('#error_content_arabic_return_seller').text('Please enter content in Arabic');
            hasError = true;
        }

        if (hasError) return;

        $.ajax({
            url: "{{ route('admin.create_update_return_policy') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                type: 2,
                content_english: editors['content_english_return_seller']?.getData() || '',
                content_arabic: editors['content_arabic_return_seller']?.getData() || ''
            },
            success: function(response) {
                toastr.success(response.message);
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Something went wrong');
            }
        });
    });

    $('#sellerAboutForm').on('submit', function(e) {
        e.preventDefault();

        let content_english = editors['content_english_about_seller'] ? editors['content_english_about_seller'].getData() : '';
        let content_arabic = editors['content_arabic_about_seller'] ? editors['content_arabic_about_seller'].getData() : '';

        let hasError = false;

        $('#error_content_english_about_seller').text('');
        $('#error_content_arabic_about_seller').text('');

        if (!content_english) {
            $('#error_content_english_about_seller').text('Please enter content in English');
            hasError = true;
        }

        if (!content_arabic) {
            $('#error_content_arabic_about_seller').text('Please enter content in Arabic');
            hasError = true;
        }

        if (hasError) return;

        $.ajax({
            url: "{{ route('admin.create_update_about_us') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                type: 2,
                content_english: editors['content_english_about_seller']?.getData() || '',
                content_arabic: editors['content_arabic_about_seller']?.getData() || ''
            },
            success: function(response) {
                toastr.success(response.message);
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Something went wrong');
            }
        });
    });

    $('#sellerCancellationForm').on('submit', function(e) {
        e.preventDefault();

        let content_english = editors['content_english_cancellation_seller'] ? editors['content_english_cancellation_seller'].getData() : '';
        let content_arabic = editors['content_arabic_cancellation_seller'] ? editors['content_arabic_cancellation_seller'].getData() : '';

        let hasError = false;

        $('#error_content_english_cancellation_seller').text('');
        $('#error_content_arabic_cancellation_seller').text('');

        if (!content_english) {
            $('#error_content_english_cancellation_seller').text('Please enter content in English');
            hasError = true;
        }

        if (!content_arabic) {
            $('#error_content_arabic_cancellation_seller').text('Please enter content in Arabic');
            hasError = true;
        }

        if (hasError) return;

        $.ajax({
            url: "{{ route('admin.create_update_cancellation_policy') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                type: 2,
                content_english: editors['content_english_cancellation_seller']?.getData() ||
                    '',
                content_arabic: editors['content_arabic_cancellation_seller']?.getData() || ''
            },
            success: function(response) {
                toastr.success(response.message);
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Something went wrong');
            }
        });
    });

    $('#sellerExchangeForm').on('submit', function(e) {
        e.preventDefault();

        let content_english = editors['content_english_exchange_seller'] ? editors['content_english_exchange_seller'].getData() : '';
        let content_arabic = editors['content_arabic_exchange_seller'] ? editors['content_arabic_exchange_seller'].getData() : '';

        let hasError = false;

        $('#error_content_english_exchange_seller').text('');
        $('#error_content_arabic_exchange_seller').text('');

        if (!content_english) {
            $('#error_content_english_exchange_seller').text('Please enter content in English');
            hasError = true;
        }

        if (!content_arabic) {
            $('#error_content_arabic_exchange_seller').text('Please enter content in Arabic');
            hasError = true;
        }

        if (hasError) return;

        $.ajax({
            url: "{{ route('admin.create_update_exchange_policy') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                type: 2,
                content_english: editors['content_english_exchange_seller']?.getData() || '',
                content_arabic: editors['content_arabic_exchange_seller']?.getData() || ''
            },
            success: function(response) {
                toastr.success(response.message);
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Something went wrong');
            }
        });
    });
    //driver
    $('#driverTermsForm').on('submit', function(e) {
        e.preventDefault();

        let content_english = editors['content_english_driver'] ? editors['content_english_driver']
            .getData() : '';
        let content_arabic = editors['content_arabic_driver'] ? editors['content_arabic_driver']
            .getData() : '';

        let hasError = false;

        $('#error_content_english_driver').text('');
        $('#error_content_arabic_driver').text('');

        if (!content_english) {
            $('#error_content_english_driver').text('Please enter content in English');
            hasError = true;
        }

        if (!content_arabic) {
            $('#error_content_arabic_driver').text('Please enter content in Arabic');
            hasError = true;
        }

        if (hasError) return;

        $.ajax({
            url: "{{ route('admin.create_update_terms_condition') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                type: 3,
                content_english: content_english,
                content_arabic: content_arabic
            },
            success: function(response) {
                toastr.success(response.message);
                // setTimeout(function () {
                //     location.reload();
                // }, 1500); 
            },
            error: function(xhr) {
                let res = xhr.responseJSON;
                toastr.error(res?.message || 'Something went wrong');
            }
        });
    });

    $('#driverReturnForm').on('submit', function(e) {
        e.preventDefault();

        let content_english = editors['content_english_return_driver'] ? editors['content_english_return_driver'].getData() : '';
        let content_arabic = editors['content_arabic_return_driver'] ? editors['content_arabic_return_driver'].getData() : '';

        let hasError = false;

        $('#error_content_english_return_driver').text('');
        $('#error_content_arabic_return_driver').text('');

        if (!content_english) {
            $('#error_content_english_return_driver').text('Please enter content in English');
            hasError = true;
        }

        if (!content_arabic) {
            $('#error_content_arabic_return_driver').text('Please enter content in Arabic');
            hasError = true;
        }

        if (hasError) return;

        $.ajax({
            url: "{{ route('admin.create_update_return_policy') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                type: 3,
                content_english: editors['content_english_return_driver']?.getData() || '',
                content_arabic: editors['content_arabic_return_driver']?.getData() || ''
            },
            success: function(response) {
                toastr.success(response.message);
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Something went wrong');
            }
        });
    });

    $('#driverAboutForm').on('submit', function(e) {
        e.preventDefault();

        let content_english = editors['content_english_about_driver'] ? editors['content_english_about_driver'].getData() : '';
        let content_arabic = editors['content_arabic_about_driver'] ? editors['content_arabic_about_driver'].getData() : '';

        let hasError = false;

        $('#error_content_english_about_driver').text('');
        $('#error_content_arabic_about_driver').text('');

        if (!content_english) {
            $('#error_content_english_about_driver').text('Please enter content in English');
            hasError = true;
        }

        if (!content_arabic) {
            $('#error_content_arabic_about_driver').text('Please enter content in Arabic');
            hasError = true;
        }

        if (hasError) return;

        $.ajax({
            url: "{{ route('admin.create_update_about_us') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                type: 3,
                content_english: editors['content_english_about_driver']?.getData() || '',
                content_arabic: editors['content_arabic_about_driver']?.getData() || ''
            },
            success: function(response) {
                toastr.success(response.message);
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Something went wrong');
            }
        });
    });

    $('#driverCancellationForm').on('submit', function(e) {
        e.preventDefault();

        let content_english = editors['content_english_cancellation_driver'] ? editors['content_english_cancellation_driver'].getData() : '';
        let content_arabic = editors['content_arabic_cancellation_driver'] ? editors['content_arabic_cancellation_driver'].getData() : '';

        let hasError = false;

        $('#error_content_english_cancellation_driver').text('');
        $('#error_content_arabic_cancellation_driver').text('');

        if (!content_english) {
            $('#error_content_english_cancellation_driver').text('Please enter content in English');
            hasError = true;
        }

        if (!content_arabic) {
            $('#error_content_arabic_cancellation_driver').text('Please enter content in Arabic');
            hasError = true;
        }

        if (hasError) return;

        $.ajax({
            url: "{{ route('admin.create_update_cancellation_policy') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                type: 3,
                content_english: editors['content_english_cancellation_driver']?.getData() ||
                    '',
                content_arabic: editors['content_arabic_cancellation_driver']?.getData() || ''
            },
            success: function(response) {
                toastr.success(response.message);
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Something went wrong');
            }
        });
    });

    $('#driverExchangeForm').on('submit', function(e) {
        e.preventDefault();

        let content_english = editors['content_english_exchange_driver'] ? editors['content_english_exchange_driver'].getData() : '';
        let content_arabic = editors['content_arabic_exchange_driver'] ? editors['content_arabic_exchange_driver'].getData() : '';

        let hasError = false;

        $('#error_content_english_exchange_driver').text('');
        $('#error_content_arabic_exchange_driver').text('');

        if (!content_english) {
            $('#error_content_english_exchange_driver').text('Please enter content in English');
            hasError = true;
        }

        if (!content_arabic) {
            $('#error_content_arabic_exchange_driver').text('Please enter content in Arabic');
            hasError = true;
        }

        if (hasError) return;

        $.ajax({
            url: "{{ route('admin.create_update_exchange_policy') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                type: 3,
                content_english: editors['content_english_exchange_driver']?.getData() || '',
                content_arabic: editors['content_arabic_exchange_driver']?.getData() || ''
            },
            success: function(response) {
                toastr.success(response.message);
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Something went wrong');
            }
        });
    });
});
</script>

<!-- add faq -->
<script>
$(document).ready(function() {

    // Remove error while typing
    $('#question_english, #answer_english, #question_arabic, #answer_arabic')
        .on('input', function() {
            let id = $(this).attr('id');
            $('.error-' + id).text('');
        });

    // Button click (NO FORM SUBMIT)
    $('#addFaqBtn').on('click', function() {

        // clear old errors
        $('.text-danger').text('');

        let question_english = $('#question_english').val().trim();
        let answer_english = $('#answer_english').val().trim();
        let question_arabic = $('#question_arabic').val().trim();
        let answer_arabic = $('#answer_arabic').val().trim();
        let type = $('#type').val();

        let hasError = false;

        // ✅ Frontend validation (instant, no reload)
        if (!question_english) {
            $('.error-question_english').text('Please enter question in English');
            hasError = true;
        }

        if (!answer_english) {
            $('.error-answer_english').text('Please enter answer in English');
            hasError = true;
        }

        if (!question_arabic) {
            $('.error-question_arabic').text('Please enter question in Arabic');
            hasError = true;
        }

        if (!answer_arabic) {
            $('.error-answer_arabic').text('Please enter answer in Arabic');
            hasError = true;
        }

        if (hasError) return;

        // disable button
        $('#addFaqBtn').prop('disabled', true).find('span').text('Saving...');

        $.ajax({
            url: "{{ route('admin.add_faq') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                type: 1,
                question_english: question_english,
                answer_english: answer_english,
                question_arabic: question_arabic,
                answer_arabic: answer_arabic
            },

            success: function(response) {
                toastr.success(response.message);

                setTimeout(function() {
                    location.reload();
                }, 1500);
            },

            error: function(xhr) {
                $('#addFaqBtn').prop('disabled', false).find('span').text('Add');

                let res = xhr.responseJSON;

                toastr.error(res?.message || 'Something went wrong');

                // backend validation (optional)
                if (res?.errors) {
                    $.each(res.errors, function(key, value) {
                        $('.error-' + key).text(value[0]);
                    });
                }
            }
        });

    });

});
</script>

<!-- user contact us -->
<script>
$(document).ready(function() {

    // Remove error on typing
    $('#email, #mobile, #whatsapp').on('input', function() {
        let name = $(this).attr('name');
        $('.error-' + name).text('');
    });

    $('#contactSubmitBtn').on('click', function() {

        $('.text-danger').text('');

        let email = $('#email').val().trim();
        let mobile = $('#mobile').val().trim();
        let whatsapp = $('#whatsapp').val().trim();

        let hasError = false;

        // ✅ Email validation
        if (!email) {
            $('.error-email').text('Please enter email');
            hasError = true;
        } else {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                $('.error-email').text('Please enter a valid email');
                hasError = true;
            }
        }

        // ✅ Mobile validation (7–15 digits)
        if (!mobile) {
            $('.error-mobile').text('Please enter contact number');
            hasError = true;
        } else {
            const mobilePattern = /^\+?[0-9]{7,15}$/;
            if (!mobilePattern.test(mobile)) {
                $('.error-mobile').text('Mobile number must be between 7 to 15 digits');
                hasError = true;
            }
        }

        if (!whatsapp) {
            $('.error-whatsapp').text('Please enter whatsapp number');
            hasError = true;
        } else {
            const whatsappPattern = /^\+?[0-9]{7,15}$/;
            if (!whatsappPattern.test(whatsapp)) {
                $('.error-whatsapp').text('WhatsApp number must be between 7 to 15 digits');
                hasError = true;
            }
        }

        if (hasError) return;

        $('#contactSubmitBtn').prop('disabled', true).find('span').text('Saving...');

        $.ajax({
            url: "{{ route('admin.create_update_contact_us') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                type: 1,
                email: email,
                mobile: mobile,
                whatsapp: whatsapp
            },

            success: function(response) {
                toastr.success(response.message);

                setTimeout(function() {
                    location.reload();
                }, 1500);
            },

            error: function(xhr) {
                $('#contactSubmitBtn').prop('disabled', false).find('span').text('Submit');

                let res = xhr.responseJSON;

                toastr.error(res?.message || 'Something went wrong');

                if (res?.errors) {
                    $.each(res.errors, function(key, value) {
                        $('.error-' + key).text(value[0]);
                    });
                }
            }
        });

    });

});
</script>

<!-- add faq seller -->
<script>
$(document).ready(function() {

    // Remove error while typing
    $('#question_english_seller, #answer_english_seller, #question_arabic_seller, #answer_arabic_seller')
        .on('input', function() {
            let id = $(this).attr('id');
            $('.error-' + id).text('');
        });

    // Button click (NO FORM SUBMIT)
    $('#addFaqBtnSeller').on('click', function() {

        // clear old errors
        $('.text-danger').text('');

        let question_english = $('#question_english_seller').val().trim();
        let answer_english = $('#answer_english_seller').val().trim();
        let question_arabic = $('#question_arabic_seller').val().trim();
        let answer_arabic = $('#answer_arabic_seller').val().trim();
        let type = $('#type_seller').val();

        let hasError = false;

        // ✅ Frontend validation (instant, no reload)
        if (!question_english) {
            $('.error-question_english_seller').text('Please enter question in English');
            hasError = true;
        }

        if (!answer_english) {
            $('.error-answer_english_seller').text('Please enter answer in English');
            hasError = true;
        }

        if (!question_arabic) {
            $('.error-question_arabic_seller').text('Please enter question in Arabic');
            hasError = true;
        }

        if (!answer_arabic) {
            $('.error-answer_arabic_seller').text('Please enter answer in Arabic');
            hasError = true;
        }

        if (hasError) return;

        // disable button
        $('#addFaqBtnSeller').prop('disabled', true).find('span').text('Saving...');

        $.ajax({
            url: "{{ route('admin.add_faq') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                type: 2,
                question_english: question_english,
                answer_english: answer_english,
                question_arabic: question_arabic,
                answer_arabic: answer_arabic
            },

            success: function(response) {
                toastr.success(response.message);

                setTimeout(function() {
                    location.reload();
                }, 1500);
            },

            error: function(xhr) {
                $('#addFaqBtnSeller').prop('disabled', false).find('span').text('Add');

                let res = xhr.responseJSON;

                toastr.error(res?.message || 'Something went wrong');

                // backend validation (optional)
                if (res?.errors) {
                    $.each(res.errors, function(key, value) {
                        $('.error-' + key).text(value[0]);
                    });
                }
            }
        });

    });

});
</script>

<!-- seller contact us -->
<script>
$(document).ready(function() {

    // Remove error on typing
    $('#email_seller, #mobile_seller, #whatsapp_seller').on('input', function() {
        let name = $(this).attr('name');
        $('.error-' + name).text('');
    });

    $('#contactSubmitBtnSeller').on('click', function() {

        $('.text-danger').text('');

        let email = $('#email_seller').val().trim();
        let mobile = $('#mobile_seller').val().trim();
        let whatsapp = $('#whatsapp_seller').val().trim();

        let hasError = false;

        // ✅ Email validation
        if (!email) {
            $('.error-email_seller').text('Please enter email');
            hasError = true;
        } else {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                $('.error-email_seller').text('Please enter a valid email');
                hasError = true;
            }
        }

        // ✅ Mobile validation (7–15 digits)
        if (!mobile) {
            $('.error-mobile_seller').text('Please enter contact number');
            hasError = true;
        } else {
            const mobilePattern = /^\+?[0-9]{7,15}$/;
            if (!mobilePattern.test(mobile)) {
                $('.error-mobile_seller').text('Mobile number must be between 7 to 15 digits');
                hasError = true;
            }
        }

        if (!whatsapp) {
            $('.error-whatsapp_seller').text('Please enter whatsapp number');
            hasError = true;
        } else {
            const whatsappPattern = /^\+?[0-9]{7,15}$/;
            if (!whatsappPattern.test(whatsapp)) {
                $('.error-whatsapp_seller').text('WhatsApp number must be between 7 to 15 digits');
                hasError = true;
            }
        }

        if (hasError) return;

        $('#contactSubmitBtnSeller').prop('disabled', true).find('span').text('Saving...');

        $.ajax({
            url: "{{ route('admin.create_update_contact_us') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                type: 2,
                email: email,
                mobile: mobile,
                whatsapp: whatsapp
            },

            success: function(response) {
                toastr.success(response.message);

                setTimeout(function() {
                    location.reload();
                }, 1500);
            },

            error: function(xhr) {
                $('#contactSubmitBtnSeller').prop('disabled', false).find('span').text(
                    'Submit');

                let res = xhr.responseJSON;

                toastr.error(res?.message || 'Something went wrong');

                if (res?.errors) {
                    $.each(res.errors, function(key, value) {
                        $('.error-' + key).text(value[0]);
                    });
                }
            }
        });

    });

});
</script>

<!-- add faq driver -->
<script>
$(document).ready(function() {

    // Remove error while typing
    $('#question_english_driver, #answer_english_driver, #question_arabic_driver, #answer_arabic_driver')
        .on('input', function() {
            let id = $(this).attr('id');
            $('.error-' + id).text('');
        });

    // Button click (NO FORM SUBMIT)
    $('#addFaqBtnDriver').on('click', function() {

        // clear old errors
        $('.text-danger').text('');

        let question_english = $('#question_english_driver').val().trim();
        let answer_english = $('#answer_english_driver').val().trim();
        let question_arabic = $('#question_arabic_driver').val().trim();
        let answer_arabic = $('#answer_arabic_driver').val().trim();
        let type = $('#type_seller').val();

        let hasError = false;

        // ✅ Frontend validation (instant, no reload)
        if (!question_english) {
            $('.error-question_english_driver').text('Please enter question in English');
            hasError = true;
        }

        if (!answer_english) {
            $('.error-answer_english_driver').text('Please enter answer in English');
            hasError = true;
        }

        if (!question_arabic) {
            $('.error-question_arabic_driver').text('Please enter question in Arabic');
            hasError = true;
        }

        if (!answer_arabic) {
            $('.error-answer_arabic_driver').text('Please enter answer in Arabic');
            hasError = true;
        }

        if (hasError) return;

        // disable button
        $('#addFaqBtnDriver').prop('disabled', true).find('span').text('Saving...');

        $.ajax({
            url: "{{ route('admin.add_faq') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                type: 3,
                question_english: question_english,
                answer_english: answer_english,
                question_arabic: question_arabic,
                answer_arabic: answer_arabic
            },

            success: function(response) {
                toastr.success(response.message);

                setTimeout(function() {
                    location.reload();
                }, 1500);
            },

            error: function(xhr) {
                $('#addFaqBtnDriver').prop('disabled', false).find('span').text('Add');

                let res = xhr.responseJSON;

                toastr.error(res?.message || 'Something went wrong');

                // backend validation (optional)
                if (res?.errors) {
                    $.each(res.errors, function(key, value) {
                        $('.error-' + key).text(value[0]);
                    });
                }
            }
        });

    });

});
</script>

<!-- seller contact us -->
<script>
$(document).ready(function() {

    // Remove error on typing
    $('#email_driver, #mobile_driver, #whatsapp_driver').on('input', function() {
        let name = $(this).attr('name');
        $('.error-' + name).text('');
    });

    $('#contactSubmitBtnDriver').on('click', function() {

        $('.text-danger').text('');

        let email = $('#email_driver').val().trim();
        let mobile = $('#mobile_driver').val().trim();
        let whatsapp = $('#whatsapp_driver').val().trim();

        let hasError = false;

        // ✅ Email validation
        if (!email) {
            $('.error-email_driver').text('Please enter email');
            hasError = true;
        } else {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                $('.error-email_driver').text('Please enter a valid email');
                hasError = true;
            }
        }

        // ✅ Mobile validation (7–15 digits)
        if (!mobile) {
            $('.error-mobile_driver').text('Please enter contact number');
            hasError = true;
        } else {
            const mobilePattern = /^\+?[0-9]{7,15}$/;
            if (!mobilePattern.test(mobile)) {
                $('.error-mobile_driver').text('Mobile number must be between 7 to 15 digits');
                hasError = true;
            }
        }

        if (!whatsapp) {
            $('.error-whatsapp_driver').text('Please enter whatsapp number');
            hasError = true;
        } else {
            const whatsappPattern = /^\+?[0-9]{7,15}$/;
            if (!whatsappPattern.test(whatsapp)) {
                $('.error-whatsapp_driver').text('WhatsApp number must be between 7 to 15 digits');
                hasError = true;
            }
        }

        if (hasError) return;

        $('#contactSubmitBtnDriver').prop('disabled', true).find('span').text('Saving...');

        $.ajax({
            url: "{{ route('admin.create_update_contact_us') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                type: 3,
                email: email,
                mobile: mobile,
                whatsapp: whatsapp
            },

            success: function(response) {
                toastr.success(response.message);

                setTimeout(function() {
                    location.reload();
                }, 1500);
            },

            error: function(xhr) {
                $('#contactSubmitBtnDriver').prop('disabled', false).find('span').text(
                    'Submit');

                let res = xhr.responseJSON;

                toastr.error(res?.message || 'Something went wrong');

                if (res?.errors) {
                    $.each(res.errors, function(key, value) {
                        $('.error-' + key).text(value[0]);
                    });
                }
            }
        });

    });

});
</script>

<!-- update user faq -->
<script>
$(document).ready(function () {

    $('#editFaqUserModal').on('show.bs.modal', function (event) {

        let button = $(event.relatedTarget);

        $('#edit_faq_id').val(button.data('id'));
        $('#edit_question_english').val(button.data('qe'));
        $('#edit_answer_english').val(button.data('ae'));
        $('#edit_question_arabic').val(button.data('qa'));
        $('#edit_answer_arabic').val(button.data('aa'));

        // clear old errors
        $('.text-danger').text('');
    });


    $('#edit_question_english, #edit_answer_english, #edit_question_arabic, #edit_answer_arabic')
    .on('input', function () {
        let id = $(this).attr('id');
        $('.error-' + id).text('');
    });


    $('#updateFaqBtn').on('click', function () {

        $('.text-danger').text('');

        let faq_id = $('#edit_faq_id').val();
        let qe = $('#edit_question_english').val().trim();
        let ae = $('#edit_answer_english').val().trim();
        let qa = $('#edit_question_arabic').val().trim();
        let aa = $('#edit_answer_arabic').val().trim();

        let hasError = false;

        if (!qe) {
            $('.error-edit_question_english').text('Please enter question in English');
            hasError = true;
        }

        if (!ae) {
            $('.error-edit_answer_english').text('Please enter answer in English');
            hasError = true;
        }

        if (!qa) {
            $('.error-edit_question_arabic').text('Please enter question in Arabic');
            hasError = true;
        }

        if (!aa) {
            $('.error-edit_answer_arabic').text('Please enter answer in Arabic');
            hasError = true;
        }

        if (hasError) return;

        // disable button
        $('#updateFaqBtn').prop('disabled', true).find('span').text('Updating...');

        $.ajax({
            url: "{{ route('admin.update_faq') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                faq_id: faq_id,
                question_english: qe,
                answer_english: ae,
                question_arabic: qa,
                answer_arabic: aa
            },

            success: function (response) {
                toastr.success(response.message);

                setTimeout(function () {
                    location.reload();
                }, 1500);
            },

            error: function (xhr) {

                $('#updateFaqBtn').prop('disabled', false).find('span').text('Update');

                let res = xhr.responseJSON;

                toastr.error(res?.message || 'Something went wrong');

                if (res?.errors) {
                    $.each(res.errors, function(key, value) {
                        $('.error-edit_' + key).text(value[0]);
                    });
                }
            }
        });

    });

});
</script>

<!-- update seller faq -->
<script>
$(document).ready(function () {

    $('#editFaqSellerModal').on('show.bs.modal', function (event) {

        let button = $(event.relatedTarget);

        $('#edit_faq_id_seller').val(button.data('id'));
        $('#edit_question_english_seller').val(button.data('qe'));
        $('#edit_answer_english_seller').val(button.data('ae'));
        $('#edit_question_arabic_seller').val(button.data('qa'));
        $('#edit_answer_arabic_seller').val(button.data('aa'));

        $('.text-danger').text('');
    });


    $('#edit_question_english_seller, #edit_answer_english_seller, #edit_question_arabic_seller, #edit_answer_arabic_seller')
    .on('input', function () {
        let id = $(this).attr('id');
        $('.error-' + id).text('');
    });


    $('#updateFaqBtnSeller').on('click', function () {

        $('.text-danger').text('');

        let faq_id = $('#edit_faq_id_seller').val();
        let qe = $('#edit_question_english_seller').val().trim();
        let ae = $('#edit_answer_english_seller').val().trim();
        let qa = $('#edit_question_arabic_seller').val().trim();
        let aa = $('#edit_answer_arabic_seller').val().trim();

        let hasError = false;

        if (!qe) {
            $('.error-edit_question_english_seller').text('Please enter question in English');
            hasError = true;
        }

        if (!ae) {
            $('.error-edit_answer_english_seller').text('Please enter answer in English');
            hasError = true;
        }

        if (!qa) {
            $('.error-edit_question_arabic_seller').text('Please enter question in Arabic');
            hasError = true;
        }

        if (!aa) {
            $('.error-edit_answer_arabic_seller').text('Please enter answer in Arabic');
            hasError = true;
        }

        if (hasError) return;

        $('#updateFaqBtnSeller').prop('disabled', true).find('span').text('Updating...');

        $.ajax({
            url: "{{ route('admin.update_faq') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                faq_id: faq_id,
                question_english: qe,
                answer_english: ae,
                question_arabic: qa,
                answer_arabic: aa
            },

            success: function (response) {
                toastr.success(response.message);

                setTimeout(function () {
                    location.reload();
                }, 1500);
            },

            error: function (xhr) {

                $('#updateFaqBtnSeller').prop('disabled', false).find('span').text('Update');

                let res = xhr.responseJSON;

                toastr.error(res?.message || 'Something went wrong');

                if (res?.errors) {
                    $.each(res.errors, function(key, value) {
                        $('.error-edit_' + key + '_seller').text(value[0]);
                    });
                }
            }
        });

    });

});
</script>

<!-- update driver faq -->
<script>
$(document).ready(function () {

    $('#editFaqDriverModal').on('show.bs.modal', function (event) {

        let button = $(event.relatedTarget);

        $('#edit_faq_id_driver').val(button.data('id'));
        $('#edit_question_english_driver').val(button.data('qe'));
        $('#edit_answer_english_driver').val(button.data('ae'));
        $('#edit_question_arabic_driver').val(button.data('qa'));
        $('#edit_answer_arabic_driver').val(button.data('aa'));

        $('.text-danger').text('');
    });


    $('#edit_question_english_driver, #edit_answer_english_driver, #edit_question_arabic_driver, #edit_answer_arabic_driver')
    .on('input', function () {
        let id = $(this).attr('id');
        $('.error-' + id).text('');
    });


    $('#updateFaqBtnDriver').on('click', function () {

        $('.text-danger').text('');

        let faq_id = $('#edit_faq_id_driver').val();
        let qe = $('#edit_question_english_driver').val().trim();
        let ae = $('#edit_answer_english_driver').val().trim();
        let qa = $('#edit_question_arabic_driver').val().trim();
        let aa = $('#edit_answer_arabic_driver').val().trim();

        let hasError = false;

        if (!qe) {
            $('.error-edit_question_english_driver').text('Please enter question in English');
            hasError = true;
        }

        if (!ae) {
            $('.error-edit_answer_english_driver').text('Please enter answer in English');
            hasError = true;
        }

        if (!qa) {
            $('.error-edit_question_arabic_driver').text('Please enter question in Arabic');
            hasError = true;
        }

        if (!aa) {
            $('.error-edit_answer_arabic_driver').text('Please enter answer in Arabic');
            hasError = true;
        }

        if (hasError) return;

        $('#updateFaqBtnDriver').prop('disabled', true).find('span').text('Updating...');

        $.ajax({
            url: "{{ route('admin.update_faq') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                faq_id: faq_id,
                question_english: qe,
                answer_english: ae,
                question_arabic: qa,
                answer_arabic: aa
            },

            success: function (response) {
                toastr.success(response.message);

                setTimeout(function () {
                    location.reload();
                }, 1500);
            },

            error: function (xhr) {

                $('#updateFaqBtnDriver').prop('disabled', false).find('span').text('Update');

                let res = xhr.responseJSON;

                toastr.error(res?.message || 'Something went wrong');

                if (res?.errors) {
                    $.each(res.errors, function(key, value) {
                        $('.error-edit_' + key + '_driver').text(value[0]);
                    });
                }
            }
        });

    });

});
</script>

<!-- delete faq -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.deleteFaq').forEach(button => {

        button.addEventListener('click', function () {

            let faqId = this.getAttribute('data-id');

            Swal.fire({
                title: "Are you sure?",
                text: "This FAQ will be permanently deleted!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {

                if (result.isConfirmed) {

                    fetch("{{ route('admin.delete_faq') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            faq_id: faqId   // ✅ IMPORTANT
                        })
                    })
                    .then(response => response.json())
                    .then(data => {

                        if (data.status === "success") {
                            toastr.success(data.message);

                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        } else {
                            toastr.error(data.message);
                        }

                    })
                    .catch(() => {
                        toastr.error('Something went wrong.');
                    });

                }

            });

        });

    });

});
</script>





@endsection