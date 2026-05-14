<?php
namespace App\Services;


use App\Models\Content;
use App\Models\Faq;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Http;


class CMSManagementService
{
   
    public function CreateUpdateTermConditions($request_data)
    {
        try {

            $title = "Terms & Conditions";
            $slug = "terms_conditions";

            $content = Content::where('slug', $slug)
                        ->where('type', $request_data->type)
                        ->first();

            if ($content) {
                $content->update([
                    'content_english' => $request_data->content_english,
                    'content_arabic' => $request_data->content_arabic,
                ]);

                $message = __('Service_messages.terms_updated_successfully');

            } else {
                $content = Content::create([
                    'type' => $request_data->type,
                    'title' => $title,
                    'slug' => $slug,
                    'content_english' => $request_data->content_english,
                    'content_arabic' => $request_data->content_arabic,
                ]);

                $message = __('Service_messages.terms_created_successfully');
            }

            return [
                'status' => 'success',
                'message' => $message,
                'data' => $content
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Failed to create/update terms & conditions: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function GetTermConditions($request_data)
    {
        try {

            $slug = "terms_conditions";

            $content = Content::where('slug', $slug)
                        ->where('type', $request_data->type)
                        ->first();

            if (!$content) {
                return [
                    'status' => 'success',
                    $message = __('Service_messages.no_data_found'),
                    'data' => (object)[]
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Terms & Conditions fetched successfully',
                'data' => $content
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Failed to fetch Terms & Conditions: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function CreateUpdateReturnPolicy($request_data)
    {
        try {

            $title = "Return Policy";
            $slug = "return_policy";

            $content = Content::where('slug', $slug)
                        ->where('type', $request_data->type)
                        ->first();

            if ($content) {
                $content->update([
                    'content_english' => $request_data->content_english,
                    'content_arabic' => $request_data->content_arabic,
                ]);

                $message = __('Service_messages.return_policy_updated_successfully');

            } else {
                $content = Content::create([
                    'type' => $request_data->type,
                    'title' => $title,
                    'slug' => $slug,
                    'content_english' => $request_data->content_english,
                    'content_arabic' => $request_data->content_arabic,
                ]);

                $message = __('Service_messages.return_policy_created_successfully');
            }

            return [
                'status' => 'success',
                'message' => $message,
                'data' => $content
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Failed to create/update return policy: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function GetReturnPolicy($request_data)
    {
        try {

            $slug = "return_policy";

            $content = Content::where('slug', $slug)
                        ->where('type', $request_data->type)
                        ->first();

            if (!$content) {
                return [
                    'status' => 'success',
                    $message = __('Service_messages.no_data_found'),
                    'data' => (object)[]
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Return Policy fetched successfully',
                'data' => $content
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Failed to fetch Return Policy: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function CreateUpdateAboutUs($request_data)
    {
        try {

            $title = "About Us";
            $slug = "about_us";

            $content = Content::where('slug', $slug)
                        ->where('type', $request_data->type)
                        ->first();

            if ($content) {
                $content->update([
                    'content_english' => $request_data->content_english,
                    'content_arabic' => $request_data->content_arabic,
                ]);

                $message = __('Service_messages.about_us_updated_successfully');

            } else {
                $content = Content::create([
                    'type' => $request_data->type,
                    'title' => $title,
                    'slug' => $slug,
                    'content_english' => $request_data->content_english,
                    'content_arabic' => $request_data->content_arabic,
                ]);

                $message = __('Service_messages.about_us_created_successfully');
            }

            return [
                'status' => 'success',
                'message' => $message,
                'data' => $content
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Failed to create/update about us: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function GetAboutUs($request_data)
    {
        try {

            $slug = "about_us";

            $content = Content::where('slug', $slug)
                        ->where('type', $request_data->type)
                        ->first();

            if (!$content) {
                return [
                    'status' => 'success',
                    $message = __('Service_messages.no_data_found'),
                    'data' => (object)[]
                ];
            }

            return [
                'status' => 'success',
                'message' => 'About Us fetched successfully',
                'data' => $content
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Failed to fetch about us: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function CreateUpdateCancellationPolicy($request_data)
    {
        try {

            $title = "Cancellation Policy";
            $slug = "cancellation_policy";

            $content = Content::where('slug', $slug)
                        ->where('type', $request_data->type)
                        ->first();

            if ($content) {
                $content->update([
                    'content_english' => $request_data->content_english,
                    'content_arabic' => $request_data->content_arabic,
                ]);

                $message = __('Service_messages.cancellation_policy_updated_successfully');

            } else {
                $content = Content::create([
                    'type' => $request_data->type,
                    'title' => $title,
                    'slug' => $slug,
                    'content_english' => $request_data->content_english,
                    'content_arabic' => $request_data->content_arabic,
                ]);

                $message = __('Service_messages.cancellation_policy_created_successfully');
            }

            return [
                'status' => 'success',
                'message' => $message,
                'data' => $content
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Failed to create/update Cancellation Policy: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function GetCancellationPolicy($request_data)
    {
        try {

            $slug = "cancellation_policy";

            $content = Content::where('slug', $slug)
                        ->where('type', $request_data->type)
                        ->first();

            if (!$content) {
                return [
                    'status' => 'success',
                    $message = __('Service_messages.no_data_found'),
                    'data' => (object)[]
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Cancellation Policy fetched successfully',
                'data' => $content
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Failed to fetch Cancellation Policy: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function CreateUpdateExchangePolicy($request_data)
    {
        try {

            $title = "Exchange Policy";
            $slug = "exchange_policy";

            $content = Content::where('slug', $slug)
                        ->where('type', $request_data->type)
                        ->first();

            if ($content) {
                $content->update([
                    'content_english' => $request_data->content_english,
                    'content_arabic' => $request_data->content_arabic,
                ]);

                $message = __('Service_messages.exchange_policy_updated_successfully');

            } else {
                $content = Content::create([
                    'type' => $request_data->type,
                    'title' => $title,
                    'slug' => $slug,
                    'content_english' => $request_data->content_english,
                    'content_arabic' => $request_data->content_arabic,
                ]);

                $message = __('Service_messages.exchange_policy_created_successfully');
            }

            return [
                'status' => 'success',
                'message' => $message,
                'data' => $content
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Failed to create/update Exchange Policy: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function GetExchangePolicy($request_data)
    {
        try {

            $slug = "exchange_policy";

            $content = Content::where('slug', $slug)
                        ->where('type', $request_data->type)
                        ->first();

            if (!$content) {
                return [
                    'status' => 'success',
                    $message = __('Service_messages.no_data_found'),
                    'data' => (object)[]
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Exchange Policy fetched successfully',
                'data' => $content
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Failed to fetch Exchange Policy: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function CreateUpdateContactUs($request_data)
    {
        try {

            $title = "Contact Us";
            $slug = "contact_us";

            $content = Content::where('slug', $slug)
                        ->where('type', $request_data->type)
                        ->first();

            if ($content) {

                $content->update([
                    'content_english' => $request_data->content_english,
                    //'content_arabic' => $request_data->content_arabic,
                ]);

                $message = __('Service_messages.contact_us_updated_successfully');

            } else {

                $content = Content::create([
                    'type' => $request_data->type,
                    'title' => $title,
                    'slug' => $slug,
                    'content_english' => $request_data->content_english,
                    //'content_arabic' => $request_data->content_arabic,
                ]);

                $message = __('Service_messages.contact_us_created_successfully');
            }

            return [
                'status' => 'success',
                'message' => $message,
                'data' => $content
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Failed to create/update Contact Us: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function GetContactUs($request_data)
    {
        try {

            $slug = "contact_us";

            $content = Content::where('slug', $slug)
                        ->where('type', $request_data->type)
                        ->first();

            if (!$content) {
                return [
                    'status' => 'success',
                    $message = __('Service_messages.no_data_found'),
                    'data' => (object)[]
                ];
            }

            $content->content_english = json_decode($content->content_english, true);

            return [
                'status' => 'success',
                'message' => 'Contact Us fetched successfully',
                'data' => $content
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Failed to fetch Contact Us: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function AddFaq($request_data)
    {
        try {

            $faq = Faq::create([
                'type' => $request_data->type,
                'question_english' => $request_data->question_english,
                'answer_english' => $request_data->answer_english,
                'question_arabic' => $request_data->question_arabic,
                'answer_arabic' => $request_data->answer_arabic,
            ]);

            return [
                'status' => 'success',
                'message' => __('Service_messages.faq_added_successfully'),
                'data' => $faq
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Failed to add FAQ: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function UpdateFaq($request_data)
    {
        try {

            $faq = Faq::find($request_data->faq_id);

            if (!$faq) {
                return [
                    'status' => 'error',
                    'message' => 'FAQ not found',
                    'data' => (object)[]
                ];
            }

            $faq->update([
                'question_english' => $request_data->question_english,
                'answer_english' => $request_data->answer_english,
                'question_arabic' => $request_data->question_arabic,
                'answer_arabic' => $request_data->answer_arabic,
            ]);

            return [
                'status' => 'success',
                'message' => __('Service_messages.faq_updated_successfully'),
                'data' => $faq
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Failed to update FAQ: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function GetFaq($request_data)
    {
        try {
            $faqs = Faq::where('type', $request_data->type)->orderBy('id', 'desc')->get();

            if ($faqs->isEmpty()) {
                return [
                    'status' => 'error',
                    $message = __('Service_messages.no_data_found'),
                    'data' => (object)[]
                ];
            }

            return [
                'status' => 'success',
                'message' => 'FAQs fetched successfully',
                'data' => $faqs
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch FAQs: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function DeleteFaq($request_data)
    {
        try {

            $faq = Faq::find($request_data->faq_id);

            if (!$faq) {
                return [
                    'status' => 'error',
                    'message' => 'FAQ not found',
                    'data' => (object)[]
                ];
            }
            $faq->delete();

            return [
                'status' => 'success',
                'message' => __('Service_messages.faq_deleted_successfully'),
                'data' => (object)[]
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Failed to delete FAQ: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }


    





}
    