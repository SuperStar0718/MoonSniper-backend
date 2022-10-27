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
        Schema::create('coins', function (Blueprint $table) {
            $table->id();
            $table->string('coin_id',100);
            $table->string('symbol',100)->unique();
            $table->string('name',150);
            $table->text('website')->nullable();
            $table->text('whitepaper')->nullable();
            $table->text('twitter')->nullable();
            $table->text('medium')->nullable();
            $table->text('reddit')->nullable();
            $table->text('github')->nullable();
            $table->text('telegram')->nullable();
            $table->text('discord')->nullable();
            $table->text('slack')->nullable();
            $table->text('0xtracker')->nullable();
            $table->text('coin_platform')->nullable();
            $table->date('genesis_date')->nullable();
            $table->text('coin_category')->nullable();
            $table->text('coin_description')->nullable();
            $table->text('contract_address')->nullable();
            $table->string('tagline')->nullable();
            $table->boolean('trading_history_flag')->default(0);
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
        Schema::dropIfExists('coins');
    }
};
