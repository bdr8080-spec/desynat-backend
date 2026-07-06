<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\country;
use App\Models\all_countrie;


use App\Helpers\ApiResponse;

class CurrencyController extends Controller
{


public function updatecurrency_price(Request $request){

$filterCurrency="KWD";

// Seller country table  Code 

$all_currency = all_countrie::where('status',1)->orderBy('orderBy','asc')->pluck('currency_code')
    ->filter()                 // remove null/empty values
    ->unique()                 // remove duplicates
    ->implode(','); 


$convert_currency=$all_currency;
$url="http://api.currencylayer.com/live?access_key=43ebb413d372c6362cf312c17fbe415d&source=$filterCurrency&currencies=$convert_currency&format=1";

// $url="http://api.currencylayer.com/live?access_key=2653f17ed11852c91f0201e2d8ea4d56&source=KWD&currencies=USD%2CAUD%2CCAD%2CPLN%2CMXN&format=1";

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);

$data= json_decode($response,true);

// Update Cuurency code 
$get_currency=$data['quotes'];

foreach($get_currency as $key =>$val){

$new_value = str_replace($filterCurrency, '', $key);

  country::where('currency_code',$new_value)->Update(['exchange_rate_to_kwd'=>$val]);
  all_countrie::where('status',1)->where('currency_code',$new_value)->Update(['exchange_rate_to_kwd'=>$val]);

}

return ApiResponse::generateResponse('success', 'Currecny price Update Successfully', $data, 200);
    



    }






}
