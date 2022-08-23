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
        Schema::create('trading_volume_history', function (Blueprint $table) {
            $table->id();
            $table->string("coin_id");
            $table->string("symbol");
            $table->json("trading_volume_history_json");
            $table->timestamps();
        });

        Schema::table('trading_volume_history', function (Blueprint $table) {
            $table->index("symbol");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trading_volume_history');
    }
};
