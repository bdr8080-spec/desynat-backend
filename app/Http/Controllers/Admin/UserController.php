<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Services\UserManagementService;
use App\Services\CountryService;

 
class UserController extends Controller
{

    public function __construct(UserManagementService $UserManagementService, CountryService $CountryService)
    {
        $this->UserManagementService = $UserManagementService;
        $this->CountryService = $CountryService;
    }


    public function userManagement(Request $request){
        $countries = $this->CountryService->getUserAllCountries()['data'];
        $users = $this->UserManagementService->getUsers($request)['data'];
       // dd($users);
        return view('admin.user-management.index',compact('countries','users'));
    }

    public function blockUnblockUser($userId)
    {
        $result = $this->UserManagementService->blockUnblockUser($userId);

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

    public function addUserWalletAmount(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'amount' => 'required|numeric|min:1'
        ]);

        $userId = $request->user_id;
        $amount = $request->amount;

        $result = $this->UserManagementService->addUserWalletAmount($userId, $amount);

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

    



}