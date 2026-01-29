<?php
namespace App\Services;
use App\Helpers\ApiResponse;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\UserContactChangeHistory;
use Hash;


use Illuminate\Support\Facades\Http;


class GoogletranslateService
{

public function translate($text,$lang)
{     
    $text = $text;
    
        $response = Http::post(
            'https://translation.googleapis.com/language/translate/v2?key=' . env('GOOGLE_TRANSLATE_API_KEY'),
            [
                'q' => $text,
                'target' => $lang  // 'ar'
            ]
        );

        if ($response->failed()) {
            return $response->json(); // shows error if any
        }
        
        return $response['data']['translations'][0]['translatedText'];
    }


}