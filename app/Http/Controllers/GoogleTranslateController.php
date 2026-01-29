<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Google\Cloud\Translate\V2\TranslateClient;
use Illuminate\Support\Facades\Http;

use Google\Cloud\Translate\V3\TranslationServiceClient;

class GoogleTranslateController extends Controller
{

public function translate_words()
{     
    $text = 'Hello how are you';

        $response = Http::post(
            'https://translation.googleapis.com/language/translate/v2?key=' . env('GOOGLE_TRANSLATE_API_KEY'),
            [
                'q' => $text,
                'target' => 'ar'
            ]
        );

        if ($response->failed()) {
            return $response->json(); // shows error if any
        }

        return $response['data']['translations'][0]['translatedText'];

    }


//  public function translate_words()
//     {

// $client = new TranslationServiceClient();

// $response = $client->translateText(
//     ['Hello how are you'],
//     'ar');

// return $response;

// }

}