<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\DeliveryBoy;
use App\Models\DeliveryBoyDocument;
use App\Http\Controllers\CommonController;
use App\Services\DeliveryBoyManagementService;
use Illuminate\Support\Facades\Session;
use Hash;
use Illuminate\Support\Facades\Storage;

 
class DeliveryBoyController extends Controller
{
    public function __construct(DeliveryBoyManagementService $DeliveryBoyManagementService)
    {
        $this->DeliveryBoyManagementService = $DeliveryBoyManagementService;
    }

    public function deliveryBoyManagement(Request $request){
        $deliveryBoys = $this->DeliveryBoyManagementService->getDeliveryBoys($request)['data'];
       // dd($deliveryBoys);
        return view('admin.delivery-boy-management.index',compact('deliveryBoys'));
    }

    public function deliveryboy_reg_step1(Request $request){
        $zones = $this->DeliveryBoyManagementService->getKuwaitZones($request)['data'];
        //dd($zones);
        if ($request->query('type') == 'session') {

            $step1Data = Session::get('deliveryboy_step1');

            return view('admin.delivery-boy-management.reg_step1', compact('step1Data','zones'));
        }
        Session::forget('deliveryboy_step1');
        return view('admin.delivery-boy-management.reg_step1',compact('zones'));
    }

    public function deliveryboy_reg_step2(Request $request){
        return view('admin.delivery-boy-management.reg_step2');
    }


    public function edit_deliveryboy_step1(Request $request, $id){
        $zones = $this->DeliveryBoyManagementService->getKuwaitZones($request)['data'];
        //  $id = $request->query('id');
        $deliveryBoy = DeliveryBoy::find($id);
        //dd($zones);
        if ($request->query('type') == 'session') {

            $step1Data = Session::get('deliveryboy_step1');

            return view('admin.delivery-boy-management.edit_reg_step1', compact('step1Data','zones','deliveryBoy'));
        }
        Session::forget('deliveryboy_step1');
        return view('admin.delivery-boy-management.edit_reg_step1',compact('deliveryBoy','zones'));
    }

    public function edit_deliveryboy_step2(Request $request){
        $step1Data = Session::get('deliveryboy_step1');
        $deliveryBoy = DeliveryBoy::with([
                'vehicle_image',
                'identity_proof',
                'driving_license',
                'vehicle_insurance',
                'pollution_paper',
                'registration_certificate',
                'zone_info',
            ])->find($step1Data['id']);
            //dd($deliveryBoy);
        return view('admin.delivery-boy-management.edit_reg_step2',compact('step1Data','deliveryBoy'));
    }



    public function change_deliveryboy_status($id)
    {
        $data = $this->DeliveryBoyManagementService->blockUnblockDeliveryBoy($id);

        if ($data['status'] == 'success') {
            $statusText = $data['data']->status == 1 ? 'Activated' : 'Deactivated';
  
            return response()->json([
                'success' => true,
                'status' => $data['data']->status,
                // 'message' => "Delivery Boy has been {$statusText} Successfully!"
                'message' => $data['message']
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => $data['message']
            ], 400); 
        }
    }


    public function deleteDeliveryBoy($id)
    {
        $result = $this->DeliveryBoyManagementService->deleteDeliveryBoy($id);

        if ($result['status'] === 'error') {
            return response()->json([
                'status' => 'error',
                'message' => $result['message']
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => $result['message']
        ], 200);
    }
    
    public function store_reg1(Request $request)
    {
        $sessionData = Session::get('deliveryboy_step1', []);
        //dd($request->all());
        $rules = [
            'profile_pic' => Session::has('deliveryboy_step1.profile_pic') ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120' : 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'full_name_english' => 'required|string|max:255',
            'full_name_arabic' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:delivery_boys,email',
            'mobile' => 'required|string|min:8|max:15|unique:delivery_boys,mobile',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'let' => 'required|string|max:255',
            'long' => 'required|string|max:255',
            'password' => [
                'required',
                'string',
                'min:6',
                // 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).+$/'
            ],
            'confirm_password' => 'required|same:password',
            'zone_id' => 'required|numeric',
        ];

        $messages = [
            'profile_pic.required' => 'Please upload a profile image.',
            'profile_pic.image' => 'The profile image must be a valid image.',
            'profile_pic.mimes' => 'The profile image must be in JPG, JPEG, or PNG format.',
            'profile_pic.max' => 'The profile image size must be less than 4MB.',
            'full_name_english.required' => 'Please enter your full name in English.',
            'full_name_english.string' => 'Full name in English must be a valid string.',
            'full_name_english.max' => 'Full name in English cannot exceed 255 characters.',
            'full_name_arabic.required' => 'Please enter your full name in Arabic.',
            'full_name_arabic.string' => 'Full name in Arabic must be a valid string.',
            'full_name_arabic.max' => 'Full name in Arabic cannot exceed 255 characters.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email address cannot exceed 255 characters.',
            'email.unique' => 'This email address is already taken.',
            'mobile.required' => 'Please enter your mobile number.',
            'mobile.string' => 'Mobile number must be a valid string.',
            'mobile.min' => 'Mobile number must be at least 8 digits.',
            'mobile.max' => 'Mobile number cannot exceed 15 digits.',
            'mobile.unique' => 'This mobile number is already registered.',
            'address_line1.required' => 'Please enter address line 1.',
            'address_line1.string' => 'Address line 1 must be a valid string.',
            'address_line1.max' => 'Address line 1 cannot exceed 255 characters.',
            'address_line2.required' => 'Please enter address line 2.',
            'address_line2.string' => 'Address line 2 must be a valid string.',
            'address_line2.max' => 'Address line 2 cannot exceed 255 characters.',
            'city.required' => 'Please enter your city.',
            'city.string' => 'City must be a valid string.',
            'city.max' => 'City name cannot exceed 100 characters.',
            'state.required' => 'Please enter your state.',
            'state.string' => 'State must be a valid string.',
            'state.max' => 'State name cannot exceed 100 characters.',
            'let.required' => 'Please enter latitude.',
            'let.string' => 'Latitude must be a valid string.',
            'let.max' => 'Latitude cannot exceed 255 characters.',
            'long.required' => 'Please enter longitude.',
            'long.string' => 'Longitude must be a valid string.',
            'long.max' => 'Longitude cannot exceed 255 characters.',
            'password.required' => 'Please enter a password.',
            'password.string' => 'Password must be a valid string.',
            'password.min' => 'Password must be at least 6 characters.',
            // 'password.regex' => 'Password must have at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character.',
            'confirm_password.required' => 'Please confirm your password.',
            'confirm_password.same' => 'The confirm password does not match the password.',
            'zone_id.required' => 'Please select a zone.',
            'zone_id.numeric' => 'Zone ID must be a valid number.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ]);
        }

        $formData = $request->except('profile_pic','confirm_password');
       //dd($request->all());

        if ($request->hasFile('profile_pic')) {
            $dir = "image";
            $upload = image_upload($request->profile_pic, $dir);
            $formData['profile_pic'] = $upload;
            } else {
                if (isset($sessionData['profile_pic'])) {
                    $formData['profile_pic'] = $sessionData['profile_pic'];
                }
            }

        // Store all form data in session
        Session::put('deliveryboy_step1', $formData);
       // dd(Session::get('deliveryboy_step1'));

        return response()->json([
            'success' => true,
            'message' => 'Data saved in session successfully.'
        ]);
    }


     public function checkMobile(Request $request)
    {
        $mobile = $request->query('value'); 

        $exists = DeliveryBoy::where('mobile', $mobile)->exists();

        return response()->json([
            'exists' => $exists
        ]);
    }


    public function checkEmail(Request $request)
    {
        $email = $request->query('value');

        $exists = DeliveryBoy::where('email', $email)->exists();

        return response()->json([
            'exists' => $exists
        ]);
    }

    public function store_reg2(Request $request)
    {
        // ---------------------------
        // 1. VALIDATION
        // ---------------------------
        $request->validate([
            'vehicle_name'          => 'required|string|max:255',
            'vehicle_reg'           => 'required|string|max:255',

            // Required uploads
            'vehicleImgFront'       => 'required|mimes:jpg,jpeg,png,gif,pdf|max:4096',
            'vehicleImgBack'        => 'required|mimes:jpg,jpeg,png,gif,pdf|max:4096',
            'idProofFront'          => 'required|mimes:jpg,jpeg,png,gif,pdf|max:4096',
            'idProofBack'           => 'required|mimes:jpg,jpeg,png,gif,pdf|max:4096',
            'dlFront'               => 'required|mimes:jpg,jpeg,png,gif,pdf|max:4096',
            'dlBack'                => 'required|mimes:jpg,jpeg,png,gif,pdf|max:4096',
            'insuranceFront'        => 'required|mimes:jpg,jpeg,png,gif,pdf|max:4096',

            // Optional uploads
            'pollutionFront'        => 'nullable|mimes:jpg,jpeg,png,gif,pdf|max:4096',
            'pollutionBack'         => 'nullable|mimes:jpg,jpeg,png,gif,pdf|max:4096',
            'rcFront'               => 'nullable|mimes:jpg,jpeg,png,gif,pdf|max:4096',
            'rcBack'                => 'nullable|mimes:jpg,jpeg,png,gif,pdf|max:4096',
        ]);

        // ---------------------------
        // 2. GET PREVIOUS SESSION DATA
        // ---------------------------
        $step1Data = Session::get('deliveryboy_step1', []);

        // ---------------------------
        // 3. UPLOAD FILES USING image_upload()
        // ---------------------------
        $uploadFields = [
            'vehicleImgFront', 'vehicleImgBack',
            'idProofFront', 'idProofBack',
            'dlFront', 'dlBack',
            'insuranceFront',
            'pollutionFront', 'pollutionBack',
            'rcFront', 'rcBack'
        ];

        $fileData = [];

        foreach ($uploadFields as $field) 
        {
            if ($request->hasFile($field)) {

                // Upload directory name
                $dir = "image";

                // Upload file using your helper (returns FULL URL)
                $fileData[$field] = $this->doc_upload($request->$field, $dir);
            }
        }

        // ---------------------------
        // 4. CURRENT FORM TEXT DATA
        // ---------------------------
        $currentData = [
            "vehicle_name" => $request->vehicle_name,
            "vehicle_reg"  => $request->vehicle_reg,
        ];

        // ---------------------------
        // 5. MERGE: PREVIOUS SESSION + CURRENT DATA + UPLOADED FILES
        // ---------------------------
        $finalSessionData = array_merge($step1Data, $currentData, $fileData);

        // ---------------------------
        // 6. SAVE BACK INTO SESSION
        // ---------------------------
        Session::put('deliveryboy_step1', $finalSessionData);

         $data = Session::get('deliveryboy_step1');
         //dd($data);

        if (!$data) {
            return back()->with('error', 'No registration data found in session.');
        }
        
        $deliveryBoy = DeliveryBoy::create([
            "profile_pic"        => $data["profile_pic"],
            "full_name_english"  => $data["full_name_english"],
            "full_name_arabic"   => $data["full_name_arabic"],
            "email"              => $data["email"],
            "country_code"       => $data["country_code"],
            "mobile"             => $data["mobile"],
            "password"           => Hash::make($data["password"]),
            "unhashed_password"  => $data["password"],
            "address_line1"      => $data["address_line1"],
            "address_line2"      => $data["address_line2"] ?? null,
            "city"               => $data["city"],
            "state"              => $data["state"],
            "let"                => $data["let"],
            "long"               => $data["long"],
            "zone_id"            => $data["zone_id"],
            "vehicle_name"       => $data["vehicle_name"],
            "vehicle_reg_no"     => $data["vehicle_reg"],   
            "document_information" => 1,
        ]);

        // -------------------------------------------------
        // Document Mapping
        // -------------------------------------------------
        $documents = [
            // vehicle image (type=1)
            "vehicleImgFront" => [1, 1],  // type, is_front
            "vehicleImgBack"  => [1, 0],

            // identity proof (type=2)
            "idProofFront" => [2, 1],
            "idProofBack"  => [2, 0],

            // driving license (type=3)
            "dlFront" => [3, 1],
            "dlBack"  => [3, 0],

            // vehicle insurance (type=4)
            "insuranceFront" => [4, 1],

            // pollution paper (type=5)
            "pollutionFront" => [5, 1],
            "pollutionBack"  => [5, 0],

            // registration certificate (type=6)
            "rcFront" => [6, 1],
            "rcBack"  => [6, 0],
        ];

        // ----------------------------------------
        // Insert Records into DeliveryBoyDocument
        // ----------------------------------------
        foreach ($documents as $field => [$docType, $isFront]) {

            if (!empty($data[$field])) { // optional fields safe check

                DeliveryBoyDocument::create([
                    "delivery_boy_id" => $deliveryBoy->id,
                    "document_type"   => $docType,
                    "document_path"   => $data[$field],   // full URL
                    "is_front"        => $isFront,
                ]);
            }
        }

        Session::forget('deliveryboy_step1');

        return response()->json([
            "success" => true,
            "message" => "Delivery Boy added successfully.",
        ]);
    }

    private function doc_upload($file, $dir)
    {
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $filePath = $dir . '/' . $fileName;
        $resp = Storage::disk('s3')->put($filePath, file_get_contents($file));
        $image_url = 'https://desynat-bucket.s3.me-south-1.amazonaws.com/' . $filePath;
        return $image_url;
    }


    public function checkMobileEdit(Request $request)
    {
        $mobile = $request->query('value'); 
        $id = $request->query('id'); // current delivery boy ID

        $exists = DeliveryBoy::where('mobile', $mobile)
            ->where('id', '!=', $id)
            ->exists();

        return response()->json([
            'exists' => $exists
        ]);
    }

    public function checkEmailEdit(Request $request)
    {
        $email = $request->query('value');
        $id = $request->query('id'); // current delivery boy ID

        $exists = DeliveryBoy::where('email', $email)
            ->where('id', '!=', $id)
            ->exists();

        return response()->json([
            'exists' => $exists
        ]);
    }


    public function store_reg1_edit(Request $request)
    {
        $sessionData = Session::get('deliveryboy_step1', []);

        $rules = [
                'profile_pic' => $request->hasFile('profile_pic') ? 'image|mimes:jpeg,png,jpg,gif|max:5120' : 'nullable',
            'full_name_english' => 'required|string|max:255',
            'full_name_arabic' => 'required|string|max:255',
            'email'  => 'required|email|max:255|unique:delivery_boys,email,'.$request->id,
            'mobile' => 'required|string|min:8|max:15|unique:delivery_boys,mobile,'.$request->id,
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'let' => 'required|string|max:255',
            'long' => 'required|string|max:255',
            'password' => [
                'required',
                'string',
                'min:6',
                // 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).+$/'
            ],
            'confirm_password' => 'required|same:password',
            'zone_id' => 'required|numeric',
        ];

        // Custom validation messages
        $messages = [
            'profile_pic.required' => 'Please upload a profile image.',
            'profile_pic.image' => 'The profile image must be a valid image.',
            'profile_pic.mimes' => 'The profile image must be in JPG, JPEG, or PNG format.',
            'profile_pic.max' => 'The profile image size must be less than 4MB.',
            'full_name_english.required' => 'Please enter your full name in English.',
            'full_name_english.string' => 'Full name in English must be a valid string.',
            'full_name_english.max' => 'Full name in English cannot exceed 255 characters.',
            'full_name_arabic.required' => 'Please enter your full name in Arabic.',
            'full_name_arabic.string' => 'Full name in Arabic must be a valid string.',
            'full_name_arabic.max' => 'Full name in Arabic cannot exceed 255 characters.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email address cannot exceed 255 characters.',
            'email.unique' => 'This email address is already taken.',
            'mobile.required' => 'Please enter your mobile number.',
            'mobile.string' => 'Mobile number must be a valid string.',
            'mobile.min' => 'Mobile number must be at least 8 digits.',
            'mobile.max' => 'Mobile number cannot exceed 15 digits.',
            'mobile.unique' => 'This mobile number is already registered.',
            'address_line1.required' => 'Please enter address line 1.',
            'address_line1.string' => 'Address line 1 must be a valid string.',
            'address_line1.max' => 'Address line 1 cannot exceed 255 characters.',
            'address_line2.required' => 'Please enter address line 2.',
            'address_line2.string' => 'Address line 2 must be a valid string.',
            'address_line2.max' => 'Address line 2 cannot exceed 255 characters.',
            'city.required' => 'Please enter your city.',
            'city.string' => 'City must be a valid string.',
            'city.max' => 'City name cannot exceed 100 characters.',
            'state.required' => 'Please enter your state.',
            'state.string' => 'State must be a valid string.',
            'state.max' => 'State name cannot exceed 100 characters.',
            'let.required' => 'Please enter latitude.',
            'let.string' => 'Latitude must be a valid string.',
            'let.max' => 'Latitude cannot exceed 255 characters.',
            'long.required' => 'Please enter longitude.',
            'long.string' => 'Longitude must be a valid string.',
            'long.max' => 'Longitude cannot exceed 255 characters.',
            'password.required' => 'Please enter a password.',
            'password.string' => 'Password must be a valid string.',
            'password.min' => 'Password must be at least 6 characters.',
            // 'password.regex' => 'Password must have at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character.',
            'confirm_password.required' => 'Please confirm your password.',
            'confirm_password.same' => 'The confirm password does not match the password.',
            'zone_id.required' => 'Please select a zone.',
            'zone_id.numeric' => 'Zone ID must be a valid number.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ]);
        }


         $formData = $request->except('confirm_password');

        if ($request->hasFile('profile_pic')) {
            $formData['profile_pic'] = image_upload($request->file('profile_pic'), 'image');
        } elseif ($request->filled('profile_pic')) {
            // If we sent existing URL from hidden input
            $formData['profile_pic'] = $request->profile_pic;
        } else {
            $formData['profile_pic'] = $sessionData['profile_pic'] ?? null;
        }

        Session::put('deliveryboy_step1', $formData);

       // dd(Session::get('deliveryboy_step1'));

        return response()->json([
            'success' => true,
            'message' => 'Data saved in session successfully.'
        ]);
    }


    public function store_reg2_edit(Request $request)
    {
        $request->validate([
            'vehicle_name'=>'required|string|max:255',
            'vehicle_reg'=>'required|string|max:255',
            'vehicleImgFront'=>'required_without:vehicleImgFront_url|mimes:jpg,jpeg,png,gif,pdf|max:4096',
            'vehicleImgBack'=>'required_without:vehicleImgBack_url|mimes:jpg,jpeg,png,gif,pdf|max:4096',
            'idProofFront'=>'required_without:idProofFront_url|mimes:jpg,jpeg,png,gif,pdf|max:4096',
            'idProofBack'=>'required_without:idProofBack_url|mimes:jpg,jpeg,png,gif,pdf|max:4096',
            'dlFront'=>'required_without:dlFront_url|mimes:jpg,jpeg,png,gif,pdf|max:4096',
            'dlBack'=>'required_without:dlBack_url|mimes:jpg,jpeg,png,gif,pdf|max:4096',
            'insuranceFront'=>'required_without:insuranceFront_url|mimes:jpg,jpeg,png,gif,pdf|max:4096',
            'pollutionFront'=>'nullable|mimes:jpg,jpeg,png,gif,pdf|max:4096',
            'pollutionBack'=>'nullable|mimes:jpg,jpeg,png,gif,pdf|max:4096',
            'rcFront'=>'nullable|mimes:jpg,jpeg,png,gif,pdf|max:4096',
            'rcBack'=>'nullable|mimes:jpg,jpeg,png,gif,pdf|max:4096',
        ]);

        $step1Data = Session::get('deliveryboy_step1', []);
        $uploadFields = [
            'vehicleImgFront','vehicleImgBack','idProofFront','idProofBack',
            'dlFront','dlBack','insuranceFront','pollutionFront','pollutionBack','rcFront','rcBack'
        ];

        $fileData = [];
        foreach($uploadFields as $field){
            if($request->hasFile($field)){
                $dir="image";
                $fileData[$field] = $this->doc_upload($request->$field,$dir);
            } elseif($request->filled($field."_url")){
                $fileData[$field] = $request->input($field."_url");
            }
        }

        $currentData = [
            "vehicle_name"=>$request->vehicle_name,
            "vehicle_reg"=>$request->vehicle_reg,
            "profile_pic"=>$step1Data["profile_pic"]??null,
            "full_name_english"=>$step1Data["full_name_english"]??null,
            "full_name_arabic"=>$step1Data["full_name_arabic"]??null,
            "email"=>$step1Data["email"]??null,
            "country_code"=>$step1Data["country_code"]??null,
            "mobile"=>$step1Data["mobile"]??null,
            "password"=>$step1Data["password"]??null,
            "unhashed_password"=>$step1Data["password"]??null,
            "address_line1"=>$step1Data["address_line1"]??null,
            "address_line2"=>$step1Data["address_line2"]??null,
            "city"=>$step1Data["city"]??null,
            "state"=>$step1Data["state"]??null,
            "let"=>$step1Data["let"]??null,
            "long"=>$step1Data["long"]??null,
            "zone_id"=>$step1Data["zone_id"]??null,
        ];

        $finalData = array_merge($step1Data, $currentData, $fileData);
        Session::put('deliveryboy_step1',$finalData);

        $deliveryBoy = DeliveryBoy::find($finalData['id']);
        if(!$deliveryBoy) return back()->with('error','Delivery Boy not found.');

        $deliveryBoy->update([
            "profile_pic"=>$finalData["profile_pic"],
            "full_name_english"=>$finalData["full_name_english"],
            "full_name_arabic"=>$finalData["full_name_arabic"],
            "email"=>$finalData["email"],
            "country_code"=>$finalData["country_code"],
            "mobile"=>$finalData["mobile"],
            "password"=>Hash::make($finalData["password"]),
            "unhashed_password"=>$finalData["unhashed_password"],
            "address_line1"=>$finalData["address_line1"],
            "address_line2"=>$finalData["address_line2"],
            "city"=>$finalData["city"],
            "state"=>$finalData["state"],
            "let"=>$finalData["let"],
            "long"=>$finalData["long"],
            "zone_id"=>$finalData["zone_id"],
            "vehicle_name"=>$finalData["vehicle_name"],
            "vehicle_reg_no"=>$finalData["vehicle_reg"],
        ]);

        $documents = [
            "vehicleImgFront"=>[1,1],"vehicleImgBack"=>[1,0],
            "idProofFront"=>[2,1],"idProofBack"=>[2,0],
            "dlFront"=>[3,1],"dlBack"=>[3,0],
            "insuranceFront"=>[4,0],
            "pollutionFront"=>[5,1],"pollutionBack"=>[5,0],
            "rcFront"=>[6,1],"rcBack"=>[6,0]
        ];

        foreach($documents as $field=>[$docType,$isFront]){
            if(!empty($finalData[$field])){
                $existingDoc = DeliveryBoyDocument::where('delivery_boy_id',$deliveryBoy->id)
                    ->where('document_type',$docType)
                    ->where('is_front',$isFront)->first();
                if($existingDoc){
                    if($existingDoc->document_path != $finalData[$field]){
                        $existingDoc->update(['document_path'=>$finalData[$field]]);
                    }
                } else {
                    DeliveryBoyDocument::create([
                        "delivery_boy_id"=>$deliveryBoy->id,
                        "document_type"=>$docType,
                        "document_path"=>$finalData[$field],
                        "is_front"=>$isFront,
                    ]);
                }
            }
        }

        Session::forget('deliveryboy_step1');

        return response()->json(["success"=>true,"message"=>"Delivery Boy updated successfully."]);
    }








}