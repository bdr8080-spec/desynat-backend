@extends('admin.layout.app')
@section('content')
@php
    $admin = auth('admin')->user();

    $permissions = \App\Models\AdminPermission::where('admin_id', $admin->id)
        ->where('can_action', 1)
        ->pluck('module_id')
        ->toArray();
@endphp

<div class="inner-content management">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">{{ __('admin_messages.delivery_boy_management') }}</h2>
        </div>

<!-- 
        <div class="col-lg-3 col-md-4 col-12">

            <div class="d-flex justify-content-end" style="text-align: end">
                <a class="btn btn-dark customBtn" style="margin-top: 70px">
                    <span>Export</span>
                </a>
            </div>
        </div> -->

    </div>

    <div class="userManagecontent mt-3">
        <div class="">
            <form method="GET" action="{{ route('admin.deliveryBoyManagement') }}" id="filterForm">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="from" class="form-label">{{ __('admin_messages.from') }}:</label>
                        <input type="date" id="from" name="from_date" class="form-control datepicker"
                            value="{{ request()->from_date }}"
                            onchange="updateToDate(); document.getElementById('filterForm').submit();" />
                    </div>
                </div>

                <!-- To Date Filter -->
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="to" class="form-label">{{ __('admin_messages.to') }}:</label>
                        <input type="date" id="to" name="to_date" class="form-control datepicker"
                            value="{{ request()->to_date }}"
                            onchange="document.getElementById('filterForm').submit();" />
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-12">
                    <div class="gap-3 " >
                        <a href="{{route('admin.deliveryBoyManagement')}}" class="btn btn-dark customBtn"
                            style="margin-top: 60px">
                            <span>{{ __('admin_messages.reset') }}</span>
                        </a>
                        @if(in_array(9, $permissions) || $admin->type == 1)
                         <a href="{{ route('admin.export_driver_data', request()->all()) }}" class="btn btn-dark customBtn" style="margin-top: 60px">
                    <span>{{ __('admin_messages.export') }}</span>
                </a>
                @endif
                    </div>
                </div>
                @if(in_array(9, $permissions) || $admin->type == 1)
                <div class="col-lg-3 col-md-12 col-12">
                    <div class="d-flex justify-content-end  mt-5 mb-5">
                        <a class="btn btn-dark customBtn"  href="{{route('admin.deliveryboy_reg_step1')}}" style="
    margin-top: -4px;
">
                            <span >{{ __('admin_messages.add_delivery_boy') }}</span>
                        </a>
                    </div>
                </div>
                @endif
            </div>
           </form>

            <div class="table-responsive w-100 mt-3">
                <table id="myTable" class="table w-100">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('admin_messages.s_no') }}</th>
                            <th scope="col">{{ __('admin_messages.joining_date') }}</th>
                            <th scope="col">{{ __('admin_messages.image') }}</th>
                            <th scope="col">{{ __('admin_messages.full_name') }}</th>
                            <th scope="col">{{ __('admin_messages.mobile_number') }}</th>
                            <th scope="col">{{ __('admin_messages.email') }}</th>
                            <th scope="col">{{ __('admin_messages.zone') }}</th>
                            <th scope="col">{{ __('admin_messages.address') }}</th>
                            <th scope="col">{{ __('admin_messages.vehicle_name') }}</th>
                            <th scope="col">{{ __('admin_messages.registration_number') }}</th>
                            <th scope="col">{{ __('admin_messages.vehicle_image') }}</th>
                            <th scope="col">{{ __('admin_messages.uploaded_id') }}</th>
                            <th scope="col">{{ __('admin_messages.uploaded_dl') }}</th>
                            <th scope="col">{{ __('admin_messages.uploaded_vehicle_insurance') }}</th>
                            <th scope="col">{{ __('admin_messages.uploaded_pollution_paper') }}</th>
                            <th scope="col">{{ __('admin_messages.uploaded_rc') }}</th>
                            <th scope="col">{{ __('admin_messages.total_order_delivered') }}</th>
                            @if(in_array(9, $permissions) || $admin->type == 1)
                            <th scope="col">{{ __('admin_messages.action') }}</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($deliveryBoys as $index => $deliveryBoy)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ formatDateTimeByLocale($deliveryBoy['created_at']) }}</td>
                            <td>
                                <img src="{{ $deliveryBoy['profile_pic'] }}" alt="" width="100px" height="100px" class="square" style="object-fit: inherit;" />
                            </td>
                            <td>{{ $deliveryBoy['full_name_english'] }}</td>

                            <td>{{ $deliveryBoy['country_code'] }}{{ $deliveryBoy['mobile'] }}</td>
                            <td>{{ $deliveryBoy['email'] }}</td>

                            <td>{{$deliveryBoy['zone_info']['name_english'] ?? 'N/A'}}</td>
                            <td>{{ $deliveryBoy['address_line1'] }}{{ $deliveryBoy['address_line2'] }}{{ $deliveryBoy['city'] }}{{ $deliveryBoy['state'] }}</td>
                            <td>{{ $deliveryBoy['vehicle_name'] }}</td>
                            <td>{{ $deliveryBoy['vehicle_reg_no'] }}</td>
                            <td> 
                                @if(!empty($deliveryBoy['vehicle_image']))
                                <a class="table-button view-vehicle-image-btn" type="button" data-bs-toggle="modal"
                                    data-bs-target="#sentModal5" data-documents='@json($deliveryBoy['vehicle_image'])'>                              
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                @else
                                N/A
                                @endif
                            </td>
                            <td>

                                @if(!empty($deliveryBoy['identity_proof']))
                                <a class="table-button view-identity-proof-btn" type="button" data-bs-toggle="modal"
                                    data-bs-target="#sentModal6" data-documents='@json($deliveryBoy['identity_proof'])'>                              
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                @else
                                N/A
                                @endif

                            </td>

                            <td>
                                @if(!empty($deliveryBoy['driving_license']))
                                <a class="table-button view-driving-license-btn" type="button" data-bs-toggle="modal"
                                    data-bs-target="#sentModal7" data-documents='@json($deliveryBoy['driving_license'])'>                              
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                @else
                                N/A
                                @endif

                            <td>
                                @if(!empty($deliveryBoy['vehicle_insurance']))
                                <a class="table-button view-vehicle-insurance-btn" type="button" data-bs-toggle="modal"
                                    data-bs-target="#sentModal8" data-documents='@json($deliveryBoy['vehicle_insurance'])'>                              
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                @else
                                N/A
                                @endif

                            </td>
                            <td>
                                @if(!empty($deliveryBoy['pollution_paper']))
                                <a class="table-button view-pollution-paper-btn" type="button" data-bs-toggle="modal"
                                    data-bs-target="#sentModal9" data-documents='@json($deliveryBoy['pollution_paper'])'>                              
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                @else
                                N/A
                                @endif
                            <td>
                                 @if(!empty($deliveryBoy['registration_certificate']))
                                <a class="table-button view-registration-certificate-btn" type="button" data-bs-toggle="modal"
                                    data-bs-target="#sentModal10" data-documents='@json($deliveryBoy['registration_certificate'])'>                              
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                @else
                                N/A
                                @endif
                            </td>
                            <td>0</td>
                            @if(in_array(9, $permissions) || $admin->type == 1)
                            <td>
                                <div class="d-flex gap-3 justify-content-center">
                                    <a class="table-button" href="{{ route('admin.edit_deliveryboy_step1', ['id' => $deliveryBoy['id']]) }}"><i  class="bi bi-pencil-square"></i></a>

                                    <a href="javascript:void(0);" class="table-button text-danger deleteDeliveryBoy mb-1 mt-1"
                                        data-id="{{ $deliveryBoy['id']  }}">
                                        <i class="bi bi-trash3-fill"></i>
                                    </a>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input toggleStatus" type="checkbox"
                                            role="switch" id="switch{{ $deliveryBoy['id'] }}" data-id="{{ $deliveryBoy['id'] }}"
                                            {{ $deliveryBoy['status'] == 1 ? 'checked' : '' }} />
                                    </div>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- vehicle image modal -->
<div class="modal fade" id="sentModal5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2" id="modalTitle">{{ __('admin_messages.vehicle_image') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="text-center mb-4">

                    <div id="documentContainer" class="appointment-container d-flex flex-wrap justify-content-center"></div>
                </div>
           </div>

        </div>
    </div>
</div>

<!-- identity proof modal -->
<div class="modal fade" id="sentModal6" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2" id="modalTitle1">{{ __('admin_messages.uploaded_id') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="text-center mb-4">

                    <div id="documentContainer1" class="appointment-container d-flex flex-wrap justify-content-center"></div>
                </div>
           </div>

        </div>
    </div>
</div>

<!-- driving license modal -->
<div class="modal fade" id="sentModal7" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2" id="modalTitle2">{{ __('admin_messages.uploaded_dl') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="text-center mb-4">

                    <div id="documentContainer2" class="appointment-container d-flex flex-wrap justify-content-center"></div>
                </div>
           </div>

        </div>
    </div>
</div>

<!-- pollution paper modal -->
<div class="modal fade" id="sentModal8" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2" id="modalTitle3">{{ __('admin_messages.uploaded_vehicle_insurance') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="text-center mb-4">

                    <div id="documentContainer3" class="appointment-container d-flex flex-wrap justify-content-center"></div>
                </div>
           </div>

        </div>
    </div>
</div>

<!-- vehicle insurance modal -->
<div class="modal fade" id="sentModal9" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2" id="modalTitle4">{{ __('admin_messages.uploaded_pollution_paper') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="text-center mb-4">

                    <div id="documentContainer4" class="appointment-container d-flex flex-wrap justify-content-center"></div>
                </div>
           </div>

        </div>
    </div>
</div>

<!-- vehicle insurance modal -->
<div class="modal fade" id="sentModal10" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2" id="modalTitle5">{{ __('admin_messages.uploaded_rc') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="text-center mb-4">

                    <div id="documentContainer5" class="appointment-container d-flex flex-wrap justify-content-center"></div>
                </div>
           </div>

        </div>
    </div>
</div>


@endsection

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- vehicle image -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const documentButtons = document.querySelectorAll('.view-vehicle-image-btn');
    const documentContainer = document.getElementById('documentContainer');
    const modalTitle = document.getElementById('modalTitle');

    if (!documentContainer || !modalTitle) return;

    //modalTitle.innerText = 'Vehicle Document';

    documentButtons.forEach(button => {
        button.addEventListener('click', function() {
            documentContainer.innerHTML = '';
            let documents = [];

            try {
                documents = JSON.parse(this.getAttribute('data-documents') || '[]');
            } catch (e) {
                console.error('Failed to parse documents JSON', e);
            }

            if (documents.length === 0) {
                documentContainer.innerHTML =
                    `<p class="text-muted">{{ __('admin_messages.no_documents_available') }}</p>`;
                return;
            }

            documents.forEach(doc => {
                const filePath = doc.document_path;
                const isFront = doc.is_front == 1 ? "{{ __('admin_messages.front') }}" : "{{ __('admin_messages.back') }}";
                const ext = filePath.split('.').pop().toLowerCase();

                const wrapper = document.createElement('div');
                wrapper.style.textAlign = 'center';
                wrapper.style.margin = '10px';
                wrapper.style.display = 'inline-block';

                const previewContainer = document.createElement('div');
                previewContainer.style.display = 'inline-block';
                previewContainer.style.cursor = 'pointer';

                // ----------------------------
                // 💠 UNIFORM PREVIEW BOX STYLE
                // ----------------------------
                const previewStyle = {
                    width: "200px",
                    height: "200px",
                    border: "1px solid #ddd",
                    borderRadius: "5px",
                    objectFit: "contain",
                    padding: "10px",
                    background: "#fafafa"
                };

                // ----------------------------
                // 📌 PDF → STATIC ICON
                // ----------------------------
                if (ext === 'pdf') {
                    const icon = document.createElement('img');
                    icon.src = "/admin/image/PDF_file_icon.svg";
                    icon.alt = "PDF File";

                    Object.assign(icon.style, previewStyle);

                    icon.addEventListener('click', () => {
                        window.open(filePath, '_blank');
                    });

                    previewContainer.appendChild(icon);
                    wrapper.appendChild(previewContainer);

                } else {
                    // ----------------------------
                    // 📌 IMAGE PREVIEW
                    // ----------------------------
                    const img = document.createElement('img');
                    img.src = filePath;
                    img.alt = "Document Image";

                    Object.assign(img.style, previewStyle);

                    img.addEventListener('click', () => {
                        window.open(filePath, '_blank');
                    });

                    previewContainer.appendChild(img);
                    wrapper.appendChild(previewContainer);
                }

                // ----------------------------
                // LABEL
                // ----------------------------
                const label = document.createElement('div');
                label.innerText = isFront;
                label.style.fontSize = '0.9rem';
                label.style.fontWeight = '500';
                label.style.marginTop = '8px';

                wrapper.appendChild(label);
                documentContainer.appendChild(wrapper);
            });
        });
    });
});

</script>

<!-- identity proof -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const documentButtons = document.querySelectorAll('.view-identity-proof-btn');
    const documentContainer = document.getElementById('documentContainer1');
    const modalTitle = document.getElementById('modalTitle1');

    if (!documentContainer || !modalTitle) return;

    documentButtons.forEach(button => {
        button.addEventListener('click', function() {
           // modalTitle.innerText = 'Identity Proof';
            documentContainer.innerHTML = '';

            let documents = [];
            try {
                documents = JSON.parse(this.getAttribute('data-documents') || '[]');
            } catch (e) {
                console.error('Failed to parse documents JSON', e);
            }

            if (documents.length === 0) {
                documentContainer.innerHTML =
                    `<p class="text-muted">{{ __('admin_messages.no_documents_available') }}</p>`;
                return;
            }

            documents.forEach(doc => {
                const filePath = doc.document_path;
                const isFront = doc.is_front ? "{{ __('admin_messages.front') }}" : "{{ __('admin_messages.back') }}";
                const ext = filePath.split('.').pop().toLowerCase();

                const wrapper = document.createElement('div');
                wrapper.style.textAlign = 'center';
                wrapper.style.margin = '10px';
                wrapper.style.display = 'inline-block';

                const previewContainer = document.createElement('div');
                previewContainer.style.display = 'inline-block';
                previewContainer.style.cursor = 'pointer';

                // ----------------------------
                // 💠 UNIFORM PREVIEW STYLE
                // ----------------------------
                const previewStyle = {
                    width: "200px",
                    height: "200px",
                    border: "1px solid #ddd",
                    borderRadius: "5px",
                    objectFit: "contain",
                    padding: "10px",
                    background: "#fafafa"
                };

                if (ext === 'pdf') {
                    // ----------------------------
                    // PDF → STATIC ICON
                    // ----------------------------
                    const icon = document.createElement('img');
                    icon.src = "/admin/image/PDF_file_icon.svg";
                    icon.alt = "PDF File";

                    Object.assign(icon.style, previewStyle);

                    icon.addEventListener('click', () => {
                        window.open(filePath, '_blank');
                    });

                    previewContainer.appendChild(icon);
                    wrapper.appendChild(previewContainer);

                } else {
                    // ----------------------------
                    // IMAGE PREVIEW
                    // ----------------------------
                    const img = document.createElement('img');
                    img.src = filePath;
                    img.alt = "Document Image";

                    Object.assign(img.style, previewStyle);

                    img.addEventListener('click', () => {
                        window.open(filePath, '_blank');
                    });

                    previewContainer.appendChild(img);
                    wrapper.appendChild(previewContainer);
                }

                // ----------------------------
                // LABEL
                // ----------------------------
                const label = document.createElement('div');
                label.innerText = isFront;
                label.style.fontSize = '0.9rem';
                label.style.fontWeight = '500';
                label.style.marginTop = '8px';

                wrapper.appendChild(label);
                documentContainer.appendChild(wrapper);
            });
        });
    });
});


</script>

<!-- driving license -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const documentButtons = document.querySelectorAll('.view-driving-license-btn');
    const documentContainer = document.getElementById('documentContainer2');
    const modalTitle = document.getElementById('modalTitle2');

    if (!documentContainer || !modalTitle) return;

    documentButtons.forEach(button => {
        button.addEventListener('click', function() {
            //modalTitle.innerText = 'Driving License';
            documentContainer.innerHTML = '';

            let documents = [];
            try {
                documents = JSON.parse(this.getAttribute('data-documents') || '[]');
            } catch (e) {
                console.error('Failed to parse documents JSON', e);
            }

            if (documents.length === 0) {
                documentContainer.innerHTML =
                    `<p class="text-muted">{{ __('admin_messages.no_documents_available') }}</p>`;
                return;
            }

            documents.forEach(doc => {
                const filePath = doc.document_path;
                const isFront = doc.is_front ? "{{ __('admin_messages.front') }}" : "{{ __('admin_messages.back') }}";
                const ext = filePath.split('.').pop().toLowerCase();

                const wrapper = document.createElement('div');
                wrapper.style.textAlign = 'center';
                wrapper.style.margin = '10px';
                wrapper.style.display = 'inline-block';

                const previewContainer = document.createElement('div');
                previewContainer.style.display = 'inline-block';
                previewContainer.style.cursor = 'pointer';

                // ----------------------------
                // UNIFORM PREVIEW STYLE
                // ----------------------------
                const previewStyle = {
                    width: "200px",
                    height: "200px",
                    border: "1px solid #ddd",
                    borderRadius: "5px",
                    objectFit: "contain",
                    padding: "10px",
                    background: "#fafafa"
                };

                if (ext === 'pdf') {
                    // PDF → STATIC ICON
                    const icon = document.createElement('img');
                    icon.src = "/admin/image/PDF_file_icon.svg";
                    icon.alt = "PDF File";
                    Object.assign(icon.style, previewStyle);

                    icon.addEventListener('click', () => {
                        window.open(filePath, '_blank');
                    });

                    previewContainer.appendChild(icon);
                    wrapper.appendChild(previewContainer);

                } else {
                    // IMAGE PREVIEW
                    const img = document.createElement('img');
                    img.src = filePath;
                    img.alt = "Document Image";
                    Object.assign(img.style, previewStyle);

                    img.addEventListener('click', () => {
                        window.open(filePath, '_blank');
                    });

                    previewContainer.appendChild(img);
                    wrapper.appendChild(previewContainer);
                }

                // LABEL
                const label = document.createElement('div');
                label.innerText = isFront;
                label.style.fontSize = '0.9rem';
                label.style.fontWeight = '500';
                label.style.marginTop = '8px';

                wrapper.appendChild(label);
                documentContainer.appendChild(wrapper);
            });
        });
    });
});

</script>

<!-- vehicle insurance -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const documentButtons = document.querySelectorAll('.view-vehicle-insurance-btn');
    const documentContainer = document.getElementById('documentContainer3');
    const modalTitle = document.getElementById('modalTitle3');

    if (!documentContainer || !modalTitle) return;

    documentButtons.forEach(button => {
        button.addEventListener('click', function() {
            //modalTitle.innerText = 'Vehicle Insurance';
            documentContainer.innerHTML = '';

            let documents = [];
            try {
                documents = JSON.parse(this.getAttribute('data-documents') || '[]');
            } catch (e) {
                console.error('Failed to parse documents JSON', e);
            }

            if (documents.length === 0) {
                documentContainer.innerHTML =
                    `<p class="text-muted">{{ __('admin_messages.no_documents_available') }}</p>`;
                return;
            }

            // Assuming there's only one document
            const doc = documents[0];
            const filePath = doc.document_path;
            const ext = filePath.split('.').pop().toLowerCase();

            const wrapper = document.createElement('div');
            wrapper.style.textAlign = 'center';
            wrapper.style.margin = '10px';
            wrapper.style.display = 'inline-block';

            // ----------------------------
            // UNIFORM PREVIEW STYLE
            // ----------------------------
            const previewStyle = {
                width: "200px",
                height: "200px",
                border: "1px solid #ddd",
                borderRadius: "5px",
                objectFit: "contain",
                padding: "10px",
                background: "#fafafa",
                cursor: "pointer"
            };

            if (ext === 'pdf') {
                // PDF → STATIC ICON
                const icon = document.createElement('img');
                icon.src = "/admin/image/PDF_file_icon.svg";
                icon.alt = "PDF File";
                Object.assign(icon.style, previewStyle);

                icon.addEventListener('click', () => {
                    window.open(filePath, '_blank');
                });

                wrapper.appendChild(icon);
            } else {
                // IMAGE PREVIEW
                const img = document.createElement('img');
                img.src = filePath;
                img.alt = "Document Image";
                Object.assign(img.style, previewStyle);

                img.addEventListener('click', () => {
                    window.open(filePath, '_blank');
                });

                wrapper.appendChild(img);
            }

            documentContainer.appendChild(wrapper);
        });
    });
});



</script>

<!-- pollution paper -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const documentButtons = document.querySelectorAll('.view-pollution-paper-btn');
    const documentContainer = document.getElementById('documentContainer4');
    const modalTitle = document.getElementById('modalTitle4');

    if (!documentContainer || !modalTitle) return;

    documentButtons.forEach(button => {
        button.addEventListener('click', function() {
           // modalTitle.innerText = 'Pollution Paper';
            documentContainer.innerHTML = '';

            let documents = [];
            try {
                documents = JSON.parse(this.getAttribute('data-documents') || '[]');
            } catch (e) {
                console.error('Failed to parse documents JSON', e);
            }

            if (documents.length === 0) {
                documentContainer.innerHTML =
                    `<p class="text-muted">{{ __('admin_messages.no_documents_available') }}</p>`;
                return;
            }

            documents.forEach(doc => {
                const filePath = doc.document_path;
                const ext = filePath.split('.').pop().toLowerCase();

                const wrapper = document.createElement('div');
                wrapper.style.textAlign = 'center';
                wrapper.style.margin = '10px';
                wrapper.style.display = 'inline-block';

                // ----------------------------
                // UNIFORM PREVIEW STYLE
                // ----------------------------
                const previewStyle = {
                    width: "200px",
                    height: "200px",
                    border: "1px solid #ddd",
                    borderRadius: "5px",
                    objectFit: "contain",
                    padding: "10px",
                    background: "#fafafa",
                    cursor: "pointer"
                };

                if (ext === 'pdf') {
                    // PDF → STATIC ICON
                    const icon = document.createElement('img');
                    icon.src = "/admin/image/PDF_file_icon.svg";
                    icon.alt = "PDF File";
                    Object.assign(icon.style, previewStyle);

                    icon.addEventListener('click', () => {
                        window.open(filePath, '_blank');
                    });

                    wrapper.appendChild(icon);
                } else {
                    // IMAGE PREVIEW
                    const img = document.createElement('img');
                    img.src = filePath;
                    img.alt = "Document Image";
                    Object.assign(img.style, previewStyle);

                    img.addEventListener('click', () => {
                        window.open(filePath, '_blank');
                    });

                    wrapper.appendChild(img);
                }

                documentContainer.appendChild(wrapper);
            });
        });
    });
});


</script>

<!-- registration certificate -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const documentButtons = document.querySelectorAll('.view-registration-certificate-btn');
    const documentContainer = document.getElementById('documentContainer5');
    const modalTitle = document.getElementById('modalTitle5');

    if (!documentContainer || !modalTitle) return;

    documentButtons.forEach(button => {
        button.addEventListener('click', function() {
           // modalTitle.innerText = 'Registration Certificate';
            documentContainer.innerHTML = '';

            let documents = [];
            try {
                documents = JSON.parse(this.getAttribute('data-documents') || '[]');
            } catch (e) {
                console.error('Failed to parse documents JSON', e);
            }

            if (documents.length === 0) {
                documentContainer.innerHTML =
                    `<p class="text-muted">{{ __('admin_messages.no_documents_available') }}</p>`;
                return;
            }

            documents.forEach(doc => {
                const filePath = doc.document_path;
                const ext = filePath.split('.').pop().toLowerCase();

                const wrapper = document.createElement('div');
                wrapper.style.textAlign = 'center';
                wrapper.style.margin = '10px';
                wrapper.style.display = 'inline-block';

                // Uniform preview style
                const previewStyle = {
                    width: "200px",
                    height: "200px",
                    border: "1px solid #ddd",
                    borderRadius: "5px",
                    objectFit: "contain",
                    padding: "10px",
                    background: "#fafafa",
                    cursor: "pointer"
                };

                if (ext === 'pdf') {
                    // PDF → static icon
                    const icon = document.createElement('img');
                    icon.src = "/admin/image/PDF_file_icon.svg";
                    icon.alt = "PDF File";
                    Object.assign(icon.style, previewStyle);

                    icon.addEventListener('click', () => {
                        window.open(filePath, '_blank');
                    });

                    wrapper.appendChild(icon);
                } else {
                    // IMAGE preview
                    const img = document.createElement('img');
                    img.src = filePath;
                    img.alt = "Document Image";
                    Object.assign(img.style, previewStyle);

                    img.addEventListener('click', () => {
                        window.open(filePath, '_blank');
                    });

                    wrapper.appendChild(img);
                }

                documentContainer.appendChild(wrapper);
            });
        });
    });
});


</script>

<!-- Delete Delivery Boy -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.deleteDeliveryBoy').forEach(button => {
        button.addEventListener('click', function() {
            let deliveryBoyId = this.getAttribute('data-id');

            Swal.fire({
                title: "{{ __('admin_messages.are_you_sure?') }}",
                text: "{{ __('admin_messages.you_wont_be_able_to_revert_this') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "{{ __('admin_messages.yes_delete_it') }}",
                cancelButtonText: "{{ __('admin_messages.cancel') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/deleteDeliveryBoy/${deliveryBoyId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                toastr.success(data.message);
                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
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

 <!-- block/unblock -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.toggleStatus').forEach(toggle => {
        toggle.addEventListener('change', function() {
            let deliveryBoyId = this.getAttribute('data-id');

            fetch(`/admin/change_deliveryboy_status/${deliveryBoyId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // toastr.success(data.message);
                        if (data.status == 1) {
                            toastr.success(data.message); // Green for active
                        } else {
                            toastr.error(data.message); // Red for deactivated
                        }
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    } else {
                        toastr.error(data.message);
                    }
                })
                .catch(error => {
                    //console.error(error);
                    toastr.error('Something went wrong while updating status.');
                });
        });
    });
});
</script>

<script>
    function updateToDate() {
        const fromDate = document.getElementById('from').value;
        const toDateInput = document.getElementById('to');
        if (fromDate) {
            toDateInput.setAttribute('min', fromDate);
        } else {
            toDateInput.removeAttribute('min');
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        updateToDate();
    });
</script>
