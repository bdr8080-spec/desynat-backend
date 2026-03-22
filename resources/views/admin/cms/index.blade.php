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
                        aria-selected="true">
                        User
                    </button>
                </li>
                <li class="nav-item m-1" role="presentation">
                    <button class="nav-link customBtn2 m-0" id="dealer-tab" data-bs-toggle="pill"
                        data-bs-target="#dealerCmsTabContent" type="button" role="tab"
                        aria-controls="dealerCmsTabContent" aria-selected="false">
                        Dealer
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
                    <form id="termsForm">
                    <div class="tab-pane fade show active" id="pills-home-user" role="tabpanel"
                        aria-labelledby="pills-home-tab-user">
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
                                        <textarea id="content_english" name="content_english" class="ckeditorfile" rowspan="5"> 
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

                    </div>
                    </form>

                    <!-- Privacy Policy -->
                    <div class="tab-pane fade" id="pills-privacy-user" role="tabpanel"
                        aria-labelledby="pills-privacy-tab-user">
                        <div class="d-flex border-bottom align-items-center mb-3">
                            <h6 class="flex-grow-1 text-start">Retrun Policy</h6>

                        </div>

                         <div class="row mt-3">
                            <div class="col-lg-6">
                                <div class="d-flex justify-content-between mb-2">
                                    <h6>English</h6>
                                    <a class="table-button eyebox mb-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                               <div class="editor-wapper mt-2">
                                    <div class="editor">
                                        <textarea name="content" class="ckeditorfile" rowspan="5"> </textarea>
                                    </div>
                               </div>
                            </div>

                            <div class="col-lg-6">
                                 <div class="d-flex justify-content-between mb-2">
                                    <h6>Arabic</h6>
                                    <a class="table-button eyebox mb-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                               <div class="editor-wapper mt-2">
                                    <div class="editor">
                                        <textarea name="content" class="ckeditorfile"> </textarea>
                                    </div>
                               </div>
                            </div>
                        </div>
                       <div class="d-flex justify-content-center mt-5">
                            <button type="submit" class="btn customBtn2 active text-white">
                               Submit
                            </button>
                        </div>
                    </div>

                    <!-- About Us -->
                    <div class="tab-pane fade" id="pills-about-user" role="tabpanel"
                        aria-labelledby="pills-about-tab-user">
                        <div class="d-flex border-bottom align-items-center mb-3">
                            <h6 class="flex-grow-1 text-start">About Us</h6>
                           
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-6">
                                <div class="d-flex justify-content-between mb-2">
                                    <h6>English</h6>
                                    <a class="table-button eyebox mb-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                               <div class="editor-wapper mt-2">
                                    <div class="editor">
                                        <textarea name="content" class="ckeditorfile" rowspan="5"> </textarea>
                                    </div>
                               </div>
                            </div>

                            <div class="col-lg-6">
                                 <div class="d-flex justify-content-between mb-2">
                                    <h6>Arabic</h6>
                                    <a class="table-button eyebox mb-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                               <div class="editor-wapper mt-2">
                                    <div class="editor">
                                        <textarea name="content" class="ckeditorfile"> </textarea>
                                    </div>
                               </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-5">
                            <button type="submit" class="btn customBtn2 active text-white">
                               Submit
                            </button>
                        </div>
                    </div>
                    <!-- cancel-policy -->
                    <div class="tab-pane fade" id="pills-cancel-user" role="tabpanel"
                        aria-labelledby="pills-cancel-tab-user">
                        <div class="d-flex border-bottom align-items-center mb-3">
                            <h6 class="flex-grow-1 text-start">Cancellation Policy</h6>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-6">
                                <div class="d-flex justify-content-between mb-2">
                                    <h6>English</h6>
                                    <a class="table-button eyebox mb-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                               <div class="editor-wapper mt-2">
                                    <div class="editor">
                                        <textarea name="content" class="ckeditorfile" rowspan="5"> </textarea>
                                    </div>
                               </div>
                            </div>

                            <div class="col-lg-6">
                                 <div class="d-flex justify-content-between mb-2">
                                    <h6>Arabic</h6>
                                    <a class="table-button eyebox mb-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                               <div class="editor-wapper mt-2">
                                    <div class="editor">
                                        <textarea name="content" class="ckeditorfile"> </textarea>
                                    </div>
                               </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-5">
                            <button type="submit" class="btn customBtn2 active text-white">
                               Submit
                            </button>
                        </div>
                    </div>

                    <!-- exchange-policy -->
                    <div class="tab-pane fade" id="pills-exchange-user" role="tabpanel"
                        aria-labelledby="pills-exchange-tab-user">
                        <div class="d-flex border-bottom align-items-center mb-3">
                            <h6 class="flex-grow-1 text-start">Exchange Policy</h6>

                            <a class="table-button eyebox mb-2" type="button" data-bs-toggle="modal"
                                data-bs-target="#editModalAbout">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                        </div>
                      <div class="row mt-3">
                            <div class="col-lg-6">
                                <div class="d-flex justify-content-between mb-2">
                                    <h6>English</h6>
                                    <a class="table-button eyebox mb-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                               <div class="editor-wapper mt-2">
                                    <div class="editor">
                                        <textarea name="content" class="ckeditorfile" rowspan="5"> </textarea>
                                    </div>
                               </div>
                            </div>

                            <div class="col-lg-6">
                                 <div class="d-flex justify-content-between mb-2">
                                    <h6>Arabic</h6>
                                    <a class="table-button eyebox mb-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                               <div class="editor-wapper mt-2">
                                    <div class="editor">
                                        <textarea name="content" class="ckeditorfile"> </textarea>
                                    </div>
                               </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-5">
                            <button type="submit" class="btn customBtn2 active text-white">
                               Submit
                            </button>
                        </div>
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
                                <div class="faq-english mb-3">
                                   <div class="form-grid">
                                        <div class="form-label">Question 1 (English)</div>
                                        <div class="form-text">
                                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Tempora impedit a molestias labore, tempore quidem consectetur? Necessitatibus, voluptatem, soluta ipsa ex assumenda, nulla dolorem consectetur reprehenderit ipsum quod dolores est.
                                        </div>

                                        <div class="form-label">Answer (English)</div>
                                        <div class="form-text">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit...
                                        </div>

                                        <div class="form-label">Question 1 (Arabic)</div>
                                        <div class="form-text">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit...
                                        </div>
                                        <div class="form-label">Answer (Arabic)</div>
                                        <div class="form-text">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit...
                                        </div>
                                    </div>
                                </div>

                                 <div class="faq-english">
                                   <div class="form-grid">
                                        <div class="form-label">Question 1 (English)</div>
                                        <div class="form-text">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit...
                                        </div>

                                        <div class="form-label">Answer (English)</div>
                                        <div class="form-text">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit...
                                        </div>

                                        <div class="form-label">Question 1 (Arabic)</div>
                                        <div class="form-text">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit...
                                        </div>
                                        <div class="form-label">Answer (Arabic)</div>
                                        <div class="form-text">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit...
                                        </div>
                                    </div>
                                </div>

                            </div>

                        
                        </div>
                    </div>

                    <!-- Contact Us -->
                    <div class="tab-pane fade" id="pills-contact-user" role="tabpanel"
                        aria-labelledby="pills-contact-tab-user">
                        <div class="d-flex border-bottom align-items-center mb-3">
                            <h5 class="flex-grow-1 text-start">Contact Us</h5>
                        </div>

                        <input type="hidden" value="" name="id" />
                        <div class="contactUs mx-auto" style="max-width: 400px">
                            <div class="form-group mb-2">
                                <label class="form-label" for="email">Email id-</label>
                                <input type="text" id="email" class="form-control space" name="email_id" />
                                <span class="text-danger" id="error-email_id"></span>
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label space" for="phone">Contact Number
                                </label>
                                <input type="tel" id="contact_us" class="form-control space" name="mobile" />
                                <input type="hidden" id="country_code" name="country_code" />
                                <span class="text-danger" id="error-mobile"></span>
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label space" for="twitter">Twitter Link</label>
                                <input type="text" id="twitter" class="form-control" name="twitter" />
                            </div>


                            <div class="d-flex justify-content-center" style="opacity: 0.5; text-decoration: none"
                                data-bs-toggle="modal" data-bs-target="#noAccessMsg">
                                <a type="button" class="btn btn-dark customBtn"><span>Submit</span></a>
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
                        <div class="d-flex border-bottom align-items-center mb-3">
                            <h6 class="flex-grow-1 text-start">Terms & Conditions</h6>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-6">
                                <div class="d-flex justify-content-between mb-2">
                                    <h6>English</h6>
                                    <a class="table-button eyebox mb-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                               <div class="editor-wapper mt-2">
                                    <div class="editor">
                                        <textarea name="content" class="ckeditorfile" rowspan="5"> </textarea>
                                    </div>
                               </div>
                            </div>

                            <div class="col-lg-6">
                                 <div class="d-flex justify-content-between mb-2">
                                    <h6>Arabic</h6>
                                    <a class="table-button eyebox mb-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                               <div class="editor-wapper mt-2">
                                    <div class="editor">
                                        <textarea name="content" class="ckeditorfile"> </textarea>
                                    </div>
                               </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-5">
                            <button type="submit" class="btn customBtn2 active text-white">
                               Submit
                            </button>
                        </div>
                    </div>

                    <!-- Privacy Policy -->
                    <div class="tab-pane fade" id="pills-privacy-dealer" role="tabpanel"
                        aria-labelledby="pills-privacy-tab-dealer">
                        <div class="d-flex border-bottom align-items-center mb-3">
                            <h6 class="flex-grow-1 text-start">Privacy Policy</h6>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-6">
                                <div class="d-flex justify-content-between mb-2">
                                    <h6>English</h6>
                                    <a class="table-button eyebox mb-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                               <div class="editor-wapper mt-2">
                                    <div class="editor">
                                        <textarea name="content" class="ckeditorfile" rowspan="5"> </textarea>
                                    </div>
                               </div>
                            </div>

                            <div class="col-lg-6">
                                 <div class="d-flex justify-content-between mb-2">
                                    <h6>Arabic</h6>
                                    <a class="table-button eyebox mb-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                               <div class="editor-wapper mt-2">
                                    <div class="editor">
                                        <textarea name="content" class="ckeditorfile"> </textarea>
                                    </div>
                               </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-5">
                            <button type="submit" class="btn customBtn2 active text-white">
                               Submit
                            </button>
                        </div>
                    </div>

                    <!-- About Us -->
                    <div class="tab-pane fade" id="pills-about-dealer" role="tabpanel"
                        aria-labelledby="pills-about-tab-dealer">
                        <div class="d-flex border-bottom align-items-center mb-3">
                            <h6 class="flex-grow-1 text-start">About Us</h6>

                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-6">
                                <div class="d-flex justify-content-between mb-2">
                                    <h6>English</h6>
                                    <a class="table-button eyebox mb-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                               <div class="editor-wapper mt-2">
                                    <div class="editor">
                                        <textarea name="content" class="ckeditorfile" rowspan="5"> </textarea>
                                    </div>
                               </div>
                            </div>

                            <div class="col-lg-6">
                                 <div class="d-flex justify-content-between mb-2">
                                    <h6>Arabic</h6>
                                    <a class="table-button eyebox mb-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                               <div class="editor-wapper mt-2">
                                    <div class="editor">
                                        <textarea name="content" class="ckeditorfile"> </textarea>
                                    </div>
                               </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-5">
                            <button type="submit" class="btn customBtn2 active text-white">
                               Submit
                            </button>
                        </div>
                    </div>
                    <!-- cancel-policy -->
                    <div class="tab-pane fade" id="pills-cancel-dealer" role="tabpanel"
                        aria-labelledby="pills-cancel-tab-dealer">
                        <div class="d-flex border-bottom align-items-center mb-3">
                            <h6 class="flex-grow-1 text-start">Cancellation Policy</h6>
                        </div>
                         <div class="row mt-3">
                            <div class="col-lg-6">
                                <div class="d-flex justify-content-between mb-2">
                                    <h6>English</h6>
                                    <a class="table-button eyebox mb-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                               <div class="editor-wapper mt-2">
                                    <div class="editor">
                                        <textarea name="content" class="ckeditorfile" rowspan="5"> </textarea>
                                    </div>
                               </div>
                            </div>

                            <div class="col-lg-6">
                                 <div class="d-flex justify-content-between mb-2">
                                    <h6>Arabic</h6>
                                    <a class="table-button eyebox mb-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                               <div class="editor-wapper mt-2">
                                    <div class="editor">
                                        <textarea name="content" class="ckeditorfile"> </textarea>
                                    </div>
                               </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-5">
                            <button type="submit" class="btn customBtn2 active text-white">
                               Submit
                            </button>
                        </div>
                     
                    </div>

                    <!-- exchange-policy -->
                    <div class="tab-pane fade" id="pills-exchange-dealer" role="tabpanel"
                        aria-labelledby="pills-exchange-tab-dealer">
                        <div class="d-flex border-bottom align-items-center mb-3">
                            <h6 class="flex-grow-1 text-start">Exchange Policy</h6>

                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-6">
                                <div class="d-flex justify-content-between mb-2">
                                    <h6>English</h6>
                                    <a class="table-button eyebox mb-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                               <div class="editor-wapper mt-2">
                                    <div class="editor">
                                        <textarea name="content" class="ckeditorfile" rowspan="5"> </textarea>
                                    </div>
                               </div>
                            </div>

                            <div class="col-lg-6">
                                 <div class="d-flex justify-content-between mb-2">
                                    <h6>Arabic</h6>
                                    <a class="table-button eyebox mb-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                               <div class="editor-wapper mt-2">
                                    <div class="editor">
                                        <textarea name="content" class="ckeditorfile"> </textarea>
                                    </div>
                               </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-5">
                            <button type="submit" class="btn customBtn2 active text-white">
                               Submit
                            </button>
                        </div>
                    </div>

                    <!-- FAQs -->
                    <div class="tab-pane fade" id="pills-faq-dealer" role="tabpanel"
                        aria-labelledby="pills-faq-tab-dealer">
                        <div class="d-flex border-bottom align-items-center mb-3">
                            <h5 class="flex-grow-1 text-start">FAQs</h5>
                            <a class="btn btn-dark customBtn mb-2" type="button" data-bs-toggle="modal"
                                data-bs-target="#faqquestionModal">Add New Question</a>

                        </div>
                        <div class="management mt-4">
                            <h6>List of Questions(English)</h6>

                            <div class="accordion" id="accordionExample">
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
                                           
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                            aria-expanded="false" aria-controls="collapseTwo">
                                            Accordion Item #2
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <strong>This is the second item’s accordion body.</strong> It is hidden by
                                            default, until
                                            the collapse plugin adds the appropriate classes that we use to style each
                                            element. These
                                            classes control the overall appearance, as well as the showing and hiding
                                            via CSS
                                            transitions. You can modify any of this with custom CSS or overriding our
                                            default variables.
                                            It’s also worth noting that just about any HTML can go within the
                                            <code>.accordion-body</code>, though the transition does limit overflow.
                                        </div>
                                    </div>
                                </div> -->
                                
                            </div>
                          
                        </div>
                    </div>

                    <!-- Contact Us -->
                    <div class="tab-pane fade" id="pills-contact-dealer" role="tabpanel"
                        aria-labelledby="pills-contact-tab-dealer">
                        <div class="d-flex border-bottom align-items-center mb-3">
                            <h5 class="flex-grow-1 text-start">Contact Us</h5>
                        </div>

                        <input type="hidden" name="id" />
                        <div class="contactUs mx-auto" style="max-width: 400px">
                            <div class="form-group mb-2">
                                <label class="form-label" for="emailDealer">Email id-</label>
                                <input type="text" id="emailDealer" class="form-control space" name="email_id_dealer" />
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label space" for="contactDealer">Contact Number</label>
                                <input type="tel" class="form-control space" name="mobile_dealer" />
                                <input type="hidden" name="country_code_dealer" />
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label space" for="twitterDealer">Twitter Link</label>
                                <input type="text" class="form-control" name="twitter_dealer" />
                            </div>


                            <div class="d-flex justify-content-center">
                                <a type="button" class="btn btn-dark customBtn">Submit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>     
        <!-- edit termsConditions -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header management border-0">
                        <h6 class=" " id="exampleModalLabel">
                            Edit Terms & Conditions
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>

                    <input type="hidden" name="slug" />
                    <div class="modal-body">
                        <div class="editor">
                        <textarea name="content" class="ckeditorfile"> </textarea>
                        </div>
                        <h6 class="text-danger" id="error-content"></h6>
                        <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="btn btn-dark customBtn">
                                <span>Submit</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- edit termsConditions dealer -->
        <div class="modal fade" id="editModalDealer" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header management border-0">
                        <h6 class=" " id="exampleModalLabel">
                            Edit Terms & Conditions
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="editor">
                            <textarea name="content" class="ckeditorfile"> </textarea>
                        </div>
                        <h6 class="text-danger" id="error-content"></h6>
                        <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="btn btn-dark customBtn">
                                <span>Submit</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- edit Privacy Policy -->
        <div class="modal fade" id="editModalPrivacy" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header management border-0">
                        <h3 class="modal-title fs-5" id="exampleModalLabel">
                            Edit Privacy Policy
                        </h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <input type="hidden" name="slug" />
                    <div class="modal-body">
                        <div class="editor">
                            <textarea name="content" class="ckeditorfile"> </textarea>
                        </div>
                        <h6 class="text-danger" id="error-content"></h6>
                        <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="btn btn-dark customBtn">
                                <span>Submit</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- edit Privacy Policy dealer-->
        <div class="modal fade" id="editModalPrivacyDealer" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header management border-0">
                        <h3 class="modal-title fs-5" id="exampleModalLabel">
                            Edit Privacy Policy
                        </h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <input type="hidden" name="slug" />
                    <div class="modal-body">
                        <div class="editor">
                             <textarea name="content" class="ckeditorfile"> </textarea>
                        </div>
                        <h6 class="text-danger" id="error-content"></h6>
                        <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="btn btn-dark customBtn">
                                <span>Submit</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- edit AboutUs -->
        <div class="modal fade" id="editModalAbout" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header management border-0">
                        <h3 class="modal-title fs-5" id="exampleModalLabel">
                            Edit About Us
                        </h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <input type="hidden" name="slug" />
                    <div class="modal-body">
                        <div class="editor">
                            <textarea name="content" class="ckeditorfile"> </textarea>
                        </div>
                        <h6 class="text-danger" id="error-content"></h6>
                        <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="btn btn-dark customBtn">
                                <span>Submit</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- edit AboutUs dealer-->
        <div class="modal fade" id="editModalAboutDealer" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header management border-0">
                        <h3 class="modal-title fs-5" id="exampleModalLabel">
                            Edit About Us
                        </h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <input type="hidden" name="slug" />
                    <div class="modal-body">
                        <div class="editor">
                            <textarea name="content" class="ckeditorfile"> </textarea>
                        </div>
                        <h6 class="text-danger" id="error-content"></h6>
                        <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="btn btn-dark customBtn">
                                <span>Submit</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- faq Question add -->
        <div class="modal fade" id="faqquestionModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header management border-0">
                        <h3 class="modal-title fs-5" id="exampleModalLabel">
                            Add FAQ USER
                        </h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="editor">
                            <div class="form-group">
                                <label> Question</label>
                                <input placeholder=" Enter Question" name="question" class="form-control mb-3"
                                    type="text" />
                                <h6 class="text-danger error-question"></h6>
                                <label> Answer</label>

                                <textarea name="answer" class="mb-3"  placeholder="Enter Answer" rows="3"
                                    cols="80"></textarea>
                                <h6 class="text-danger error-answer"></h6>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                <button type="submit" class="btn btn-dark customBtn">
                                    <span>Add</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- faq Question add dealer-->
        <div class="modal fade" id="faqquestionModalDealer" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header management border-0">
                        <h3 class="modal-title fs-5" id="exampleModalLabel">
                            Add FAQ DEALER
                        </h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="editor">
                            <div class="form-group">
                                <label> Question</label>
                                <input placeholder=" Enter Question" name="question_dealer" class="form-control mb-3"
                                    type="text" />
                                <h6 class="text-danger error-question"></h6>
                                <label> Answer</label>

                                <textarea name="answer_dealer" class="mb-3" id="editor13" placeholder="Enter Answer"
                                    rows="3" cols="80"></textarea>
                                <h6 class="text-danger error-answer"></h6>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                <button type="submit" class="btn btn-dark customBtn">
                                    <span>Add</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- faq Question edit-->
        <div class="modal fade" id="editfaqquestionModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
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
                                <input placeholder=" Enter Question" class="form-control mb-3" type="text"
                                    id="faq_question" name="question" />
                                <h6 class="text-danger error-question"></h6>
                                <label> Answer</label>

                                <textarea class="mb-3" id="editor4" placeholder="Enter Answer" rows="3" cols="80"
                                    name="answer"></textarea>
                                <h6 class="text-danger error-answer"></h6>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                <button type="submit" class="btn btn-dark customBtn">
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
                                <button type="submit" class="btn btn-dark customBtn">
                                    <span>Update</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<!-- <script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.ckeditorfile').forEach(function(element) {
        ClassicEditor
            .create(element)
            .catch(error => {
                console.error(error);
            });
    });
});
</script> -->

<script>
$(document).ready(function () {
    CKEDITOR.replace('content_english');
    CKEDITOR.replace('content_arabic');
});
</script>
<!-- user tems & condition -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
let editors = {};

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.ckeditorfile').forEach(function(element) {
        ClassicEditor
            .create(element)
            .then(editor => {
                editors[element.name] = editor; 
            .catch(error => console.error(error));
    });

    $('#termsForm').on('submit', function(e) {
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
            },
            error: function(xhr) {
                let res = xhr.responseJSON;
                toastr.error(res?.message || 'Something went wrong');
            }
        });
    });
});
</script>





