<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Rate;
use \Cache;
use Artisan;

class Rates extends Controller
{

 public function convert(Request $request) {
    if ($request->IsMethod('post')){

        // request validation
        $request->validate([
            'currency' => 'required|string',
            'amount' => 'required|numeric|min:1',
        ]);

    $apikey = env('CURRCONV_API');

    // get currency value from post request
    $currency = $request->input('currency');

    // convert string to uppercase to be able to access the value in the array
    $uppercaseCurrency = strtoupper($request->input('currency'));

    // Separating each currency from the other
    $explodeCurrency = $pieces = explode("_", $currency);
    $amount = $request->input('amount');

    // retrieving an item from the cache, but also store a default value if the requested item doesn't exist
    $json = Cache::remember($currency, now()->addMinutes(15) , function () use ($currency,$apikey) {
     return  $json = file_get_contents("https://free.currconv.com/api/v7/convert?q={$currency}&compact=ultra&apiKey={$apikey}");
    });


    $obj = json_decode($json, true);
    
    $val = floatval($obj[$uppercaseCurrency]);
    $total = $val * $amount ;

    $convertedAmount = number_format($total, 3, '.', '');

    // check if there is no rates in DB get will get it from API and save it to DB , incase of the cron not started yet
    if (Rate::all()->isEmpty()){
        Artisan::call('rates:update');
        //yesterday value 
        $yesterdayRate = Rate::all()->last()->$currency;
    } else {
        // yesterday value 
        $yesterdayRate = Rate::all()->last()->$currency;
    }


    // Calculate the percent difference between two numbers
    $percentChange = (1 - $yesterdayRate / $val) * 100;


   return [
       'originalAmount' => $amount,
       'originalCurrency' =>  $explodeCurrency[0],
       'exchangeRate' => $convertedAmount,
       'exchangeCurrency' =>  $explodeCurrency[1],
       'differenceFromYesterday' =>  number_format($percentChange , 3, '.', '')
   ];
    // abort if the user sent get request
    } else {
        return abort(404);
    } 
 }

}
