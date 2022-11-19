<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange_tickers', function (Blueprint $table) {
            $table->id();
            $table->string('exchange');
            $table->string('exchange_id');
            $table->foreign('exchange_id')->references('exchangeid')->on('exchanges')->onUpdate('cascade')->onDelete('cascade');
            $table->string('base')->nullable();
            $table->string('target')->nullable();
            $table->decimal('volume',25,10)->nullable();
            $table->longText('trade_url')->nullable();
           
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
        Schema::dropIfExists('exchange_tickers');
    }
};
