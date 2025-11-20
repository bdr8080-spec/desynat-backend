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
        return view('admin.delivery-boy-management.reg_step1',compact('zones'));
    }

    public function deliveryboy_reg_step2(Request $request){
        return view('admin.delivery-boy-management.reg_step2');
    }

    public function edit_deliveryboy_step1(Request $request){
        return view('admin.delivery-boy-management.edit_reg_step1');
    }

    public function edit_deliveryboy_step2(Request $request){
        return view('admin.delivery-boy-management.edit_reg_step2');
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
        //dd($request->all());
        $rules = [
            'profile_pic'    => 'required|image|mimes:jpeg,jpg,png|max:4096', // max 4MB
            'full_name_english'     => 'required|string|max:255',
            'full_name_arabic'     => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:delivery_boys,email', 
            'mobile' => 'required|string|max:20|unique:delivery_boys,mobile',
            'address_line1'    => 'required|string|max:255',
            'address_line2'    => 'required|string|max:255',
            'city'             => 'required|string|max:100',
            'state'            => 'required|string|max:100',
            'let'            => 'required|string|max:255',
            'long'            => 'required|string|max:255',
            'password'         => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).+$/'
            ],
            'confirm_password' => 'required|same:password',
            'zone_id'          => 'required|numeric',
        ];

        $messages = [
            'profile_pic.required' => 'Please upload profile image.',
            'profile_pic.image'    => 'Profile image must be an image.',
            'profile_pic.mimes'    => 'Profile image must be JPG, JPEG, or PNG.',
            'profile_pic.max'      => 'Profile image must be less than 4MB.',
            'password.regex'       => 'Password must have at least 1 uppercase, 1 lowercase, 1 number, and 1 special character.',
            'confirm_password.same'=> 'Confirm password does not match password.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ]);
        }

        $formData = $request->except('confirm_password');
       // dd($request->profile_pic);

        // Upload profile image and store URL
        if($request->hasFile('profile_pic')){
            $commonController = new CommonController();
            $uploadResult = $commonController->upload($request);
            $uploadResultArray = $uploadResult->getData(true); 

            if ($uploadResultArray['status'] === 'error') {
                return response()->json(['success' => false, 'message' => $uploadResultArray['message']]);
            }

            $formData['profile_pic'] = $uploadResultArray['data']['url'];
        }

        // Store all form data in session
        Session::put('deliveryboy_step1', $formData);
       // dd(Session::get('deliveryboy_step1'));

        return response()->json([
            'success' => true,
            'message' => 'Data saved in session successfully.'
        ]);
    }

    // public function store_reg1(Request $request)
    // {
    //     // Validate the incoming data
    //     $rules = [
    //         'profile_pic' => 'required|image|mimes:jpeg,jpg,png|max:4096', // max 4MB
    //         'full_name_english' => 'required|string|max:255',
    //         'full_name_arabic' => 'required|string|max:255',
    //         'email' => 'required|email|max:255|unique:delivery_boys,email',
    //         'mobile' => 'required|string|min:8|max:15|unique:delivery_boys,mobile',
    //         'address_line1' => 'required|string|max:255',
    //         'address_line2' => 'required|string|max:255',
    //         'city' => 'required|string|max:100',
    //         'state' => 'required|string|max:100',
    //         'let' => 'required|string|max:255',
    //         'long' => 'required|string|max:255',
    //         'password' => [
    //             'required',
    //             'string',
    //             'min:8',
    //             'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).+$/'
    //         ],
    //         'confirm_password' => 'required|same:password',
    //         'zone_id' => 'required|numeric',
    //     ];

    //     $messages = [
    //         'profile_pic.required' => 'Please upload a profile image.',
    //         'profile_pic.image' => 'The profile image must be a valid image.',
    //         'profile_pic.mimes' => 'The profile image must be in JPG, JPEG, or PNG format.',
    //         'profile_pic.max' => 'The profile image size must be less than 4MB.',
    //         'full_name_english.required' => 'Please enter your full name in English.',
    //         'full_name_english.string' => 'Full name in English must be a valid string.',
    //         'full_name_english.max' => 'Full name in English cannot exceed 255 characters.',
    //         'full_name_arabic.required' => 'Please enter your full name in Arabic.',
    //         'full_name_arabic.string' => 'Full name in Arabic must be a valid string.',
    //         'full_name_arabic.max' => 'Full name in Arabic cannot exceed 255 characters.',
    //         'email.required' => 'Please enter your email address.',
    //         'email.email' => 'Please enter a valid email address.',
    //         'email.max' => 'Email address cannot exceed 255 characters.',
    //         'email.unique' => 'This email address is already taken.',
    //         'mobile.required' => 'Please enter your mobile number.',
    //         'mobile.string' => 'Mobile number must be a valid string.',
    //         'mobile.min' => 'Mobile number must be at least 8 digits.',
    //         'mobile.max' => 'Mobile number cannot exceed 15 digits.',
    //         'mobile.unique' => 'This mobile number is already registered.',
    //         'address_line1.required' => 'Please enter address line 1.',
    //         'address_line1.string' => 'Address line 1 must be a valid string.',
    //         'address_line1.max' => 'Address line 1 cannot exceed 255 characters.',
    //         'address_line2.required' => 'Please enter address line 2.',
    //         'address_line2.string' => 'Address line 2 must be a valid string.',
    //         'address_line2.max' => 'Address line 2 cannot exceed 255 characters.',
    //         'city.required' => 'Please enter your city.',
    //         'city.string' => 'City must be a valid string.',
    //         'city.max' => 'City name cannot exceed 100 characters.',
    //         'state.required' => 'Please enter your state.',
    //         'state.string' => 'State must be a valid string.',
    //         'state.max' => 'State name cannot exceed 100 characters.',
    //         'let.required' => 'Please enter latitude.',
    //         'let.string' => 'Latitude must be a valid string.',
    //         'let.max' => 'Latitude cannot exceed 255 characters.',
    //         'long.required' => 'Please enter longitude.',
    //         'long.string' => 'Longitude must be a valid string.',
    //         'long.max' => 'Longitude cannot exceed 255 characters.',
    //         'password.required' => 'Please enter a password.',
    //         'password.string' => 'Password must be a valid string.',
    //         'password.min' => 'Password must be at least 8 characters.',
    //         'password.regex' => 'Password must have at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character.',
    //         'confirm_password.required' => 'Please confirm your password.',
    //         'confirm_password.same' => 'The confirm password does not match the password.',
    //         'zone_id.required' => 'Please select a zone.',
    //         'zone_id.numeric' => 'Zone ID must be a valid number.',
    //     ];


    //     $validator = Validator::make($request->all(), $rules, $messages);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }
    //     //dd($request->all());

    //     $formData = $request->except('profile_pic', 'confirm_password');

    //     if ($request->hasFile('profile_pic')) {
    //         $commonController = new CommonController();
    //         $uploadResult = $commonController->upload($request);
    //         $uploadResultArray = $uploadResult->getData(true); 

    //         if ($uploadResultArray['status'] === 'error') {
    //             return redirect()->back()->with('error', $uploadResultArray['message']);
    //         }

    //         $formData['profile_pic'] = $uploadResultArray['data']['url'];
    //     }

    //     Session::put('deliveryboy_step1', $formData);
    //     dd(Session::get('deliveryboy_step1'));
        

    //     // Redirect to the next step of the registration process
    //     return redirect()->route('admin.deliveryboy_reg_step2')->with('success', 'Data saved in session successfully.');
    // }





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



}