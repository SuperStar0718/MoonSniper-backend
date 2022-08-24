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
        Schema::create('dashboard', function (Blueprint $table) {
            $table->id();
            $table->integer('fear_greed_index')->nullable();
            $table->text('market_cap')->nullable();
            $table->text('vol_24h')->nullable();
            $table->text('btc_dom')->nullable();
            $table->text('eth_dom')->nullable();
            $table->string('fear_greed_classification',100)->nullable();
            $table->text('fear_greed_history')->nullable();
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
        Schema::dropIfExists('dashboard');
    }
};
