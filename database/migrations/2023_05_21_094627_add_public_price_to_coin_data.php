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
        Schema::table('coin_data', function (Blueprint $table) {
            $table->double('public_price')->nullable()->after('type');
            $table->dateTime('public_date')->nullable()->after('public_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coin_data', function (Blueprint $table) {
            $table->dropColumn('public_price');
            $table->dropColumn('public_date');
        });
    }
};
