<?php

namespace App\Http\Controllers\Api\Admin;

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

    public function get_terms_condition(Request $request)
    {
         $validate = Validator::make($request->all(), [
            'type' => 'required|in:1,2,3',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 400);
        }

        try {
            $request_data = (object)[
                'type' => $request->type,
            ];
            $data = $this->CMSManagementService->GetTermConditions($request_data);

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

    public function get_return_policy(Request $request)
    {
         $validate = Validator::make($request->all(), [
            'type' => 'required|in:1,2,3',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 400);
        }

        try {
            $request_data = (object)[
                'type' => $request->type,
            ];
            $data = $this->CMSManagementService->GetReturnPolicy($request_data);

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

    public function get_about_us(Request $request)
    {
         $validate = Validator::make($request->all(), [
            'type' => 'required|in:1,2,3',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 400);
        }

        try {
            $request_data = (object)[
                'type' => $request->type,
            ];
            $data = $this->CMSManagementService->GetAboutUs($request_data);

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

    public function get_cancellation_policy(Request $request)
    {
         $validate = Validator::make($request->all(), [
            'type' => 'required|in:1,2,3',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 400);
        }

        try {
            $request_data = (object)[
                'type' => $request->type,
            ];
            $data = $this->CMSManagementService->GetCancellationPolicy($request_data);

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

    public function get_exchange_policy(Request $request)
    {
         $validate = Validator::make($request->all(), [
            'type' => 'required|in:1,2,3',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 400);
        }

        try {
            $request_data = (object)[
                'type' => $request->type,
            ];
            $data = $this->CMSManagementService->GetExchangePolicy($request_data);

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

    public function get_contact_us(Request $request)
    {
         $validate = Validator::make($request->all(), [
            'type' => 'required|in:1,2,3',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 400);
        }

        try {
            $request_data = (object)[
                'type' => $request->type,
            ];
            $data = $this->CMSManagementService->GetContactUs($request_data);

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

    public function get_faq(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'type' => 'required|in:1,2,3',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 400);
        }

        try {

            $request_data = (object)[
                'type' => $request->type,
            ];

            $data = $this->CMSManagementService->GetFaq($request_data);

            if ($data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }













    

    


      






}
