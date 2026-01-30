<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Google\Cloud\Translate\V2\TranslateClient;
use Illuminate\Support\Facades\Http;

use Google\Cloud\Translate\V3\TranslationServiceClient;


use App\Services\GoogletranslateService;

class GoogleTranslateController extends Controller
{

    public function __construct(GoogletranslateService $GoogletranslateService)
{
    $this->GoogletranslateService = $GoogletranslateService;
}



public function translate_words()
{     
    $text = 'Hello rahul My Name is Manoj Chauhan';
    
   $data= $this->GoogletranslateService->translate($text,'ar');

   dd($data);
   
        // $response = Http::post(
        //     'https://translation.googleapis.com/language/translate/v2?key=' . env('GOOGLE_TRANSLATE_API_KEY'),
        //     [
        //         'q' => $text,
        //         'target' => 'ar'
        //     ]
        // );

        // if ($response->failed()) {
        //     return $response->json(); // shows error if any
        // }
        // return $response['data']['translations'][0]['translatedText'];


    }


}