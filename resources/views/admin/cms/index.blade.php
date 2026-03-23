@extends('admin.layout.app')
@section('content')



<div class="inner-content management mb-5">
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
                        aria-selected="false">
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
                                aria-controls="pills-home-user" aria-selected="false">
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
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn customBtn2 active text-white">
                                    Submit
                                </button>
                            </div>

                        </form>
                        </div>

                    <!-- Privacy Policy -->
                    
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
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn customBtn2 active text-white">
                                    Submit
                                </button>
                            </div>
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
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn customBtn2 active text-white">
                                    Submit
                                </button>
                            </div>
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
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn customBtn2 active text-white">
                                    Submit
                                </button>
                            </div>
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
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn customBtn2 active text-white">
                                    Submit
                                </button>
                            </div>
                        </form>
                        </div>

                    <!-- FAQs -->
                    <div class="tab-pane fade" id="pills-faq-user" role="tabpanel" aria-labelledby="pills-faq-tab-user">
                        <div class="d-flex border-bottom align-items-center mb-3">
                            <h5 class="flex-grow-1 text-start">FAQs</h5>
                            <a class="btn btn-dark customBtn mb-2" type="button" data-bs-toggle="modal"
                                data-bs-target="#faqquestionModal">Add New Question</a>
                        </div>
                        <div class="management mt-4">
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

                                        <div class="d-flex gap-3 justify-content-center ">
                                            <a class="table-button" href="#" type="button">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a href="#" class="table-button text-danger deletePromoCode mb-1 mt-1">
                                                <i class="bi bi-trash3-fill"></i>
                                            </a>
                                        </div>

                                    </div>

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
                    <!-- <div class="tab-pane fade" id="pills-contact-user" role="tabpanel"
                        aria-labelledby="pills-contact-tab-user">
                        <div class="d-flex border-bottom align-items-center mb-3">
                            <h5 class="flex-grow-1 text-start">Contact Us</h5>
                        </div>

                        <input type="hidden" value="1" name="type" />
                        <div class="contactUs mx-auto" style="max-width: 400px">
                            <div class="form-group mb-2">
                                <label class="form-label" for="email">Email id</label>
                                <input type="text" id="email" class="form-control space" name="email" />
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label space" for="phone">Contact Number
                                </label>
                                <input type="tel" id="mobile" class="form-control space" name="mobile" />
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label space" for="twitter">Whatsapp Number</label>
                                <input type="text" id="whatsapp" class="form-control" name="whatsapp" />
                            </div>


                            <div class="d-flex justify-content-center" style="opacity: 0.5; text-decoration: none"
                                data-bs-toggle="modal" data-bs-target="#noAccessMsg">
                                <a type="button" class="btn btn-dark customBtn"><span>Submit</span></a>
                            </div>
                        </div>
                    </div> -->
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
                                    value="{{ $userContactUs->content_english['mobile'] ?? '' }}" />
                                <h6 class="text-danger error-mobile"></h6>
                            </div>

                            <div class="form-group mb-2">
                                <label class="form-label space" for="twitter">Whatsapp Number</label>
                                <input type="text" id="whatsapp" class="form-control" name="whatsapp"
                                    placeholder="Enter Whatsapp Number"
                                    value="{{ $userContactUs->content_english['whatsapp'] ?? '' }}" />
                                <h6 class="text-danger error-whatsapp"></h6>
                            </div>

                            <div class="d-flex justify-content-center mt-3">
                                <button type="button" id="contactSubmitBtn" class="btn btn-dark customBtn">
                                    <span>Submit</span>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade show" id="dealerCmsTabContent" role="tabpanel" aria-labelledby="dealer-tab">
                <!-- Inner Tabs for CMS -->
                <div class="d-flex justify-content-center mb-3">
                    <ul class="nav nav-pills tabs-pnl custom" id="userCmsTab" role="tablist">
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 active m-0" id="pills-home-tab-dealer"
                                data-bs-toggle="pill" data-bs-target="#pills-home-dealer" type="button" role="tab"
                                aria-controls="pills-home-dealer" aria-selected="false">
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
                            <button class="nav-link customBtn2 m-0" id="pills-cancel-tab-user" data-bs-toggle="pill"
                                data-bs-target="#pills-cancel-dealer" type="button" role="tab"
                                aria-controls="pills-cancel-user" aria-selected="false">
                                Cancellation Policy
                            </button>
                        </li>
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 m-0" id="pills-exchange-tab-user" data-bs-toggle="pill"
                                data-bs-target="#pills-exchange-dealer" type="button" role="tab"
                                aria-controls="pills-exchange-user" aria-selected="false">
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
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn customBtn2 active text-white">
                                    Submit
                                </button>
                            </div>

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
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn customBtn2 active text-white">
                                    Submit
                                </button>
                            </div>
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
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn customBtn2 active text-white">
                                    Submit
                                </button>
                            </div>
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
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn customBtn2 active text-white">
                                    Submit
                                </button>
                            </div>
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
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn customBtn2 active text-white">
                                    Submit
                                </button>
                            </div>
                        </form>
                        </div>

                    <!-- FAQs -->
                    <div class="tab-pane fade" id="pills-faq-dealer" role="tabpanel"
                        aria-labelledby="pills-faq-tab-dealer">
                        <div class="d-flex border-bottom align-items-center mb-3">
                            <h5 class="flex-grow-1 text-start">FAQs</h5>
                            <a class="btn btn-dark customBtn mb-2" type="button" data-bs-toggle="modal"
                                data-bs-target="#faqquestionModalSeller">Add New Question</a>
                        </div>
                        <div class="management mt-4">
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
                                    value="{{ $sellerContactUs->content_english['mobile'] ?? '' }}" />
                                <h6 class="text-danger error-mobile_seller"></h6>
                            </div>

                            <div class="form-group mb-2">
                                <label class="form-label space" for="twitter">Whatsapp Number</label>
                                <input type="text" id="whatsapp_seller" class="form-control" name="whatsapp_seller"
                                    placeholder="Enter Whatsapp Number"
                                    value="{{ $sellerContactUs->content_english['whatsapp'] ?? '' }}" />
                                <h6 class="text-danger error-whatsapp_seller"></h6>
                            </div>

                            <div class="d-flex justify-content-center mt-3">
                                <button type="button" id="contactSubmitBtnSeller" class="btn btn-dark customBtn">
                                    <span>Submit</span>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Delivery Boy -->
            <div class="tab-pane fade show " id="deliveryboy" role="tabpanel" aria-labelledby="user-tab">
                <!-- Inner Tabs for CMS -->
                <div class="d-flex justify-content-center mb-3">
                    <ul class="nav nav-pills tabs-pnl custom" id="userCmsTab" role="tablist">
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 active m-0" id="pills-home3-tab-user"
                                data-bs-toggle="pill" data-bs-target="#pills-home3-user" type="button" role="tab"
                                aria-controls="pills-home3-user" aria-selected="false">
                                Terms & Conditions
                            </button>
                        </li>

                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 m-0" id="pills-privacy3-tab-user" data-bs-toggle="pill"
                                data-bs-target="#pills-privacy3-user" type="button" role="tab"
                                aria-controls="pills-privacy3-user" aria-selected="false">
                                Return Policy
                            </button>
                        </li>
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 m-0" id="pills-about3-tab-user" data-bs-toggle="pill"
                                data-bs-target="#pills-about3-user" type="button" role="tab"
                                aria-controls="pills-about3-user" aria-selected="false">
                                About Us
                            </button>
                        </li>
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 m-0" id="pills-cancel3-tab-user" data-bs-toggle="pill"
                                data-bs-target="#pills-cancel3-user" type="button" role="tab"
                                aria-controls="pills-cancel3-user" aria-selected="false">
                                Cancellation Policy
                            </button>
                        </li>
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 m-0" id="pills-exchange3-tab-user" data-bs-toggle="pill"
                                data-bs-target="#pills-exchange3-user" type="button" role="tab"
                                aria-controls="pills-exchange3-user" aria-selected="false">
                                Exchange Policy
                            </button>
                        </li>
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 m-0" id="pills-faq3-tab-user" data-bs-toggle="pill"
                                data-bs-target="#pills-faq3-user" type="button" role="tab" aria-controls="pills-faq3-user"
                                aria-selected="false">
                                FAQs
                            </button>
                        </li>
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 m-0" id="pills-contact3-tab-user" data-bs-toggle="pill"
                                data-bs-target="#pills-contact3-user" type="button" role="tab"
                                aria-controls="pills-contact3-user" aria-selected="false">
                                Contact Us
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- User CMS Tab Content -->

                <div class="tab-content" id="deliveryboy">
                    <!-- Terms & Conditions -->
                        <div class="tab-pane fade show active" id="pills-home3-user" role="tabpanel"
                            aria-labelledby="pills-home3-tab-user">
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
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn customBtn2 active text-white">
                                    Submit
                                </button>
                            </div>

                        </form>
                        </div>

                    <!-- Privacy Policy -->
                    
                        <div class="tab-pane fade" id="pills-privacy3-user" role="tabpanel"
                            aria-labelledby="pills-privacy3-tab-user">
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
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn customBtn2 active text-white">
                                    Submit
                                </button>
                            </div>
                        </form>
                        </div>

                    <!-- About Us -->
                  
                        <div class="tab-pane fade" id="pills-about3-user" role="tabpanel"
                            aria-labelledby="pills-about3-tab-user">
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
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn customBtn2 active text-white">
                                    Submit
                                </button>
                            </div>
                        </form>
                        </div>
                    <!-- cancel-policy -->
                    
                        <div class="tab-pane fade" id="pills-cancel3-user" role="tabpanel"
                            aria-labelledby="pills-cancel3-tab-user">
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
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn customBtn2 active text-white">
                                    Submit
                                </button>
                            </div>
                        </form>
                        </div>

                    <!-- exchange-policy -->
                   
                        <div class="tab-pane fade" id="pills-exchange3-user" role="tabpanel"
                            aria-labelledby="pills-exchange3-tab-user">
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
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn customBtn2 active text-white">
                                    Submit
                                </button>
                            </div>
                        </form>
                        </div>

                    <!-- FAQs -->
                    <div class="tab-pane fade" id="pills-faq3-user" role="tabpanel" aria-labelledby="pills-faq3-tab-user">
                        <div class="d-flex border-bottom align-items-center mb-3">
                            <h5 class="flex-grow-1 text-start">FAQs</h5>
                            <a class="btn btn-dark customBtn mb-2" type="button" data-bs-toggle="modal"
                                data-bs-target="#faqquestionModal">Add New Question</a>
                        </div>
                        <div class="management mt-4">
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

                                        <div class="d-flex gap-3 justify-content-center ">
                                            <a class="table-button" href="javascript:void(0)" type="button" data-bs-toggle="modal"
                                            data-bs-target="#editFAQ">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a href="javascript:void(0)" class="table-button text-danger deletePromoCode mb-1 mt-1">
                                                <i class="bi bi-trash3-fill"></i>
                                            </a>
                                        </div>
                                        
                                    </div>
                                </div>
                                @empty
                                <div class="text-center text-muted">
                                    No FAQs found.
                                </div>
                                @endforelse
                            </div>


                        </div>
                    </div>

                    
                    <div class="tab-pane fade" id="pills-contact3-user" role="tabpanel"
                        aria-labelledby="pills-contact3-tab-user">

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
                                    value="{{ $userContactUs->content_english['mobile'] ?? '' }}" />
                                <h6 class="text-danger error-mobile"></h6>
                            </div>

                            <div class="form-group mb-2">
                                <label class="form-label space" for="twitter">Whatsapp Number</label>
                                <input type="text" id="whatsapp" class="form-control" name="whatsapp"
                                    placeholder="Enter Whatsapp Number"
                                    value="{{ $userContactUs->content_english['whatsapp'] ?? '' }}" />
                                <h6 class="text-danger error-whatsapp"></h6>
                            </div>

                            <div class="d-flex justify-content-center mt-3">
                                <button type="button" id="contactSubmitBtn" class="btn btn-dark customBtn">
                                    <span>Submit</span>
                                </button>
                            </div>

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
                    <input id="question_arabic" class="form-control mb-2" type="text"
                        placeholder="Enter Question in Arabic"
                        oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')">
                    <h6 class="text-danger error-question_arabic"></h6>

                    <label>Answer Arabic</label>
                    <textarea id="answer_arabic" class="form-control mb-2" placeholder="Enter Answer in Arabic"
                        oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')"></textarea>
                    <h6 class="text-danger error-answer_arabic"></h6>

                    <input type="hidden" id="type_seller" value="1">

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
                    <input id="question_arabic_seller" class="form-control mb-2" type="text"
                        placeholder="Enter Question in Arabic"
                        oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')">
                    <h6 class="text-danger error-question_arabic_seller"></h6>

                    <label>Answer Arabic</label>
                    <textarea id="answer_arabic_seller" class="form-control mb-2" placeholder="Enter Answer in Arabic"
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


<!-- faq Question edit-->
<div class="modal fade" id="editfaqquestionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h3 class="modal-title fs-5" id="exampleModalLabel">
                    Edit Faqs
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="id" />
                <div class="editor">
                    <div class="form-group">
                        <label> Question </label>
                        <input placeholder=" Enter Question" class="form-control mb-3" type="text" id="faq_question"
                            name="question" />
                        <h6 class="text-danger error-question"></h6>
                        <label> Answer</label>

                        <textarea class="mb-3" id="editor4" placeholder="Enter Answer" rows="3" cols="80"
                            name="answer"></textarea>
                        <h6 class="text-danger error-answer"></h6>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <button type="submit" class="btn customBtn2 active text-white">
                            <span>Update</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- faq Question edit dealer-->
<div class="modal fade" id="editfaqquestionModalDealer" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h3 class="modal-title fs-5" id="exampleModalLabel">
                    Edit Faqs
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="faq_id" name="id" />
                <div class="editor">
                    <div class="form-group">
                        <label> Question </label>
                        <input placeholder=" Enter Question" class="form-control mb-3" type="text"
                            id="faq_question_dealer" name="question_dealer" />
                        <h6 class="text-danger error-question"></h6>
                        <label> Answer</label>

                        <textarea class="mb-3" placeholder="Enter Answer" rows="3" cols="80"
                            name="answer_dealer"></textarea>
                        <h6 class="text-danger error-answer"></h6>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <button type="submit" class="btn customBtn2 active text-white">
                            <span>Update</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Delievry boy faq Question -->
<div class="modal fade" id="editFAQ" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h3 class="modal-title fs-5">
                    Edit Faqs
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
               
                <div class="editor">
                    <div class="form-group">
                        <label> Question </label>
                        <input placeholder=" Enter Question" class="form-control mb-3" type="text"
                            id="faq_question_dealer" name="question_dealer" />
                        <h6 class="text-danger error-question"></h6>
                        <label> Answer</label>

                        <textarea class="mb-3" placeholder="Enter Answer" rows="3" cols="80"
                            name="answer_dealer"></textarea>
                        <h6 class="text-danger error-answer"></h6>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <button type="submit" class="btn customBtn2 active text-white">
                            <span>Update</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



<!-- <script>
$(document).ready(function () {
    CKEDITOR.replace('content_english');
    CKEDITOR.replace('content_arabic');
});
</script> -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    //get active tab from local storage
    const lastTab = localStorage.getItem("activeTab");
    if (lastTab) {
        const triggerEl = document.querySelector(`#${lastTab}`);
        if (triggerEl) {
            const tab = new bootstrap.Tab(triggerEl);
            tab.show();
        }
    }
    //save active tab to local storage
    const tabButtons = document.querySelectorAll('button[data-bs-toggle="pill"]');
    tabButtons.forEach((button) => {
        button.addEventListener("shown.bs.tab", function() {
            localStorage.setItem("activeTab", this.id);
        });
    });
});
</script>

<!-- user tems & condition -->
<script>
let editors = {};

document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.ckeditorfile').forEach(function(element) {
        ClassicEditor
            .create(element)
            .then(editor => {
                editors[element.name] = editor;
            })
            .catch(error => console.error(error));
    });

    $('#userTermsForm').on('submit', function(e) {
        e.preventDefault();

        let content_english = editors['content_english'] ? editors['content_english'].getData() : '';
        let content_arabic = editors['content_arabic'] ? editors['content_arabic'].getData() : '';

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
                type: type,
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

        $('#contactSubmitBtn').prop('disabled', true).find('span').text('Saving...');

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





@endsection