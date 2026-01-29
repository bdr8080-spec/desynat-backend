<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Google\Cloud\Translate\V2\TranslateClient;
use Illuminate\Support\Facades\Http;

use Google\Cloud\Translate\V3\TranslationServiceClient;

class GoogleTranslateController extends Controller
{
//     public function translate_words()
//     {     
        
// $projectId = 'your-project-id';
// $location  = 'global';

// $response = Http::withToken(
//     trim(shell_exec('gcloud auth application-default print-access-token'))
// )->post(
//     "https://translation.googleapis.com/v3/projects/{$projectId}/locations/{$location}:translateText",
//     [
//         'contents' => ['Hello how are you'],
//         'targetLanguageCode' => 'ar'
//     ]
// );

// return $response->json();


//     }


 public function translate_words()
    {

$client = new TranslationServiceClient();

$response = $client->translateText(
    ['Hello how are you'],
    'ar');

return $response;

}

}