<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Rate;
use \Cache;

class rateUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rates:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Exchange Rates';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $apikey = env('CURRCONV_API');

  /**
   * due to free API limitation, I cant add all currencies,
   *  because there is a 100 request limit per hour, so i hardcoded the most popular currencies.
   */

      $currencies = array( 
                           "eur_usd",
                           "cny_usd",
                           "jpy_usd",
                           "gbp_usd",
                           "chf_usd",
                           "egp_usd",
                           "sar_usd",
                           "kwd_usd",
                           "aed_usd"
                        );
    
      $exchangeRates = [];
    
      foreach ($currencies as $key => $currency) {
     // retrieving an item from the cache, but also store a default value if the requested item doesn't exist
      $json = Cache::remember($currency, now()->addMinutes(15) , function () use ($currency,$apikey){
        return $json = file_get_contents("https://free.currconv.com/api/v7/convert?q={$currency}&compact=ultra&apiKey={$apikey}");
    });

      $obj = json_decode($json, true);
      
      // convert string to uppercase to be able to access the value in the array
      $valUppercase = strtoupper($currency);
      $val = $obj[$valUppercase];

      // make an array of currencies values
      array_push($exchangeRates,$val);
      }
    
      if(is_array($currencies)) {
         // fill every currency with it's value 
        foreach($currencies as $key => $value) {
            $filledArray[$value] = $exchangeRates[$key];
        }
    }

    // store currencies to database
    Rate::updateOrCreate($filledArray);

    }
}
