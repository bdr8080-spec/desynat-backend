<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\CMSManagementService;
use App\Models\country;


use Validator;

class CMSController extends Controller
{

    public function __construct(CMSManagementService $CMSManagementService){

        $this->CMSManagementService=$CMSManagementService;

    }

    public function cmsManagement(Request $request){
        $request_data = (object)[
                'type' => '1',
            ];
            $userterms = $this->CMSManagementService->GetTermConditions($request_data)['data'];
            //dd($userterms);
        $request_data1 = (object)[
                'type' => '1',
            ];
            $userreturn = $this->CMSManagementService->GetReturnPolicy($request_data1)['data'];

        $request_data2 = (object)[
                'type' => '1',
            ];
            $userabout = $this->CMSManagementService->GetAboutUs($request_data2)['data'];

        $request_data3 = (object)[
                'type' => '1',
            ];
            $usercancellation = $this->CMSManagementService->GetCancellationPolicy($request_data3)['data'];
        
        $request_data4 = (object)[
                'type' => '1',
            ];
            $userexchange = $this->CMSManagementService->GetExchangePolicy($request_data4)['data'];

        $request_data5 = (object)[
                'type' => '1',
            ];
            $userfaq = $this->CMSManagementService->GetFaq($request_data5)['data'];

        $request_data6 = (object)[
                'type' => '1',
            ];
            $userContactUs = $this->CMSManagementService->GetContactUs($request_data6)['data'];
        //dd($userContactUs);
        $request_data7 = (object)[
                'type' => '2',
            ];
            $sellerterms = $this->CMSManagementService->GetTermConditions($request_data7)['data'];
            //dd($userterms);
        $request_data8 = (object)[
                'type' => '2',
            ];
            $sellerreturn = $this->CMSManagementService->GetReturnPolicy($request_data8)['data'];

        $request_data9 = (object)[
                'type' => '2',
            ];
            $sellerabout = $this->CMSManagementService->GetAboutUs($request_data9)['data'];

        $request_data10 = (object)[
                'type' => '2',
            ];
            $sellercancellation = $this->CMSManagementService->GetCancellationPolicy($request_data10)['data'];
        
        $request_data11 = (object)[
                'type' => '2',
            ];
            $sellerexchange = $this->CMSManagementService->GetExchangePolicy($request_data11)['data'];

        $request_data12 = (object)[
                'type' => '2',
            ];
            $sellerfaq = $this->CMSManagementService->GetFaq($request_data12)['data'];

        $request_data13 = (object)[
                'type' => '2',
            ];
            $sellerContactUs = $this->CMSManagementService->GetContactUs($request_data13)['data'];
        return view('admin.cms.index',compact('userterms','userreturn','userabout','usercancellation','userexchange','userfaq','userContactUs','sellerterms','sellerreturn','sellerabout','sellercancellation','sellerexchange','sellerfaq','sellerContactUs'));
    }


    public function create_update_terms_condition(Request $request)
    {
         $validate = Validator::make($request->all(), [
            'type' => 'required|in:1,2,3',
            'content_english' => 'required',
            'content_arabic' => 'required',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 400);
        }

        try {
            $request_data = (object)[
                'type' => $request->type,
                'content_english' => $request->content_english,
                'content_arabic' => $request->content_arabic,
            ];
            $data = $this->CMSManagementService->CreateUpdateTermConditions($request_data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }


    public function create_update_return_policy(Request $request)
    {
         $validate = Validator::make($request->all(), [
            'type' => 'required|in:1,2,3',
            'content_english' => 'required',
            'content_arabic' => 'required',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 400);
        }

        try {
            $request_data = (object)[
                'type' => $request->type,
                'content_english' => $request->content_english,
                'content_arabic' => $request->content_arabic,
            ];
            $data = $this->CMSManagementService->CreateUpdateReturnPolicy($request_data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }


    public function create_update_about_us(Request $request)
    {
         $validate = Validator::make($request->all(), [
            'type' => 'required|in:1,2,3',
            'content_english' => 'required',
            'content_arabic' => 'required',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 400);
        }

        try {
            $request_data = (object)[
                'type' => $request->type,
                'content_english' => $request->content_english,
                'content_arabic' => $request->content_arabic,
            ];
            $data = $this->CMSManagementService->CreateUpdateAboutUs($request_data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }


    public function create_update_cancellation_policy(Request $request)
    {
         $validate = Validator::make($request->all(), [
            'type' => 'required|in:1,2,3',
            'content_english' => 'required',
            'content_arabic' => 'required',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 400);
        }

        try {
            $request_data = (object)[
                'type' => $request->type,
                'content_english' => $request->content_english,
                'content_arabic' => $request->content_arabic,
            ];
            $data = $this->CMSManagementService->CreateUpdateCancellationPolicy($request_data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }


    public function create_update_exchange_policy(Request $request)
    {
         $validate = Validator::make($request->all(), [
            'type' => 'required|in:1,2,3',
            'content_english' => 'required',
            'content_arabic' => 'required',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 400);
        }

        try {
            $request_data = (object)[
                'type' => $request->type,
                'content_english' => $request->content_english,
                'content_arabic' => $request->content_arabic,
            ];
            $data = $this->CMSManagementService->CreateUpdateExchangePolicy($request_data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }


    public function create_update_contact_us(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'type' => 'required|in:1,2,3',
            'email' => 'required|email',
            'mobile' => 'required',
            'whatsapp' => 'required',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 400);
        }

        try {

            $contact_data = [
                "email" => $request->email,
                "mobile" => $request->mobile,
                "whatsapp" => $request->whatsapp
            ];

            $request_data = (object)[
                'type' => $request->type,
                'content_english' => json_encode($contact_data),
                //'content_arabic' => json_encode($contact_data),
            ];

            $data = $this->CMSManagementService->CreateUpdateContactUs($request_data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }


    public function add_faq(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'type' => 'required|in:1,2,3',
            'question_english' => 'required',
            'answer_english' => 'required',
            'question_arabic' => 'required',
            'answer_arabic' => 'required'
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 400);
        }

        try {

            $request_data = (object)[
                'type' => $request->type,
                'question_english' => $request->question_english,
                'answer_english' => $request->answer_english,
                'question_arabic' => $request->question_arabic,
                'answer_arabic' => $request->answer_arabic,
               
            ];

            $data = $this->CMSManagementService->AddFaq($request_data);

            if ($data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function update_faq(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'faq_id' => 'required|exists:faqs,id',
            'question_english' => 'required',
            'answer_english' => 'required',
            'question_arabic' => 'required',
            'answer_arabic' => 'required'
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 400);
        }

        try {

            $request_data = (object)[
                'faq_id' => $request->faq_id,
                'question_english' => $request->question_english,
                'answer_english' => $request->answer_english,
                'question_arabic' => $request->question_arabic,
                'answer_arabic' => $request->answer_arabic,
            ];

            $data = $this->CMSManagementService->UpdateFaq($request_data);

            if ($data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }


    public function delete_faq(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'faq_id' => 'required|exists:faqs,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 400);
        }

        try {

            $request_data = (object)[
                'faq_id' => $request->faq_id,
            ];

            $data = $this->CMSManagementService->DeleteFaq($request_data);

            if ($data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }













    

    


      






}
