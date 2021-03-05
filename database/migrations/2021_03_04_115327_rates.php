<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Rates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->text('eur_usd')->nullable(); 
            $table->text('cny_usd')->nullable();
            $table->text('jpy_usd')->nullable();
            $table->text('gbp_usd')->nullable();
            $table->text('chf_usd')->nullable();
            $table->text('egp_usd')->nullable();
            $table->text('sar_usd')->nullable();
            $table->text('kwd_usd')->nullable();
            $table->text('aed_usd')->nullable();
		    $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rates');
    }
}
