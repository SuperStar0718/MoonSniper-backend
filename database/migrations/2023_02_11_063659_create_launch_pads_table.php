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
        Schema::create('launch_pads', function (Blueprint $table) {
            $table->id();
            $table->text('icon')->nullable();
            $table->text('launchpad')->nullable();
            $table->text('project')->nullable();
            $table->text('category')->nullable();
            $table->double('market_cap')->nullable();
            $table->text('thicker')->nullable();
            $table->dateTime('launch_time')->nullable();
            $table->dateTime('first_unlock_time')->nullable();
            $table->text('network')->nullable();
            $table->bigInteger('ido_public_number')->nullable();
            $table->text('telegram')->nullable();
            $table->text('website')->nullable();
            $table->text('twitter')->nullable();
            $table->text('tokenomies')->nullable();
            $table->text('contract')->nullable();
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
        Schema::dropIfExists('launch_pads');
    }
};
