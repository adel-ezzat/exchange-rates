<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable = [
        "eur_usd",
        "cny_usd",
        "jpy_usd",
        "gbp_usd",
        "chf_usd",
        "egp_usd",
        "sar_usd",
        "kwd_usd",
        "aed_usd"
];  
}
