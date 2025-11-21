<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\ApiResponse;
use App\Services\UserManagementService;
use Validator;

class UserStoreController extends Controller
{

    public function __construct(UserManagementService $UserManagementService){

        $this->UserManagementService=$UserManagementService;
           
    }

    public function store_details($id){

        $validate = Validator::make(['id'=>$id], [
            // "profile_image"=>"required",
            'id' => 'required|exists:seller_store_information,id',
        ]);

        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }

        


        return view('user.category.index');
    }









    
}