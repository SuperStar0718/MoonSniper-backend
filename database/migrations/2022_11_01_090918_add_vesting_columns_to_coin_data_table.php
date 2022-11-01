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
            if (Schema::hasColumn('coin_data', 'vesting_chart'))
            {
                Schema::table('coin_data', function (Blueprint $table)
                {
                    $table->dropColumn('vesting_chart');
                });
            }
            if (Schema::hasColumn('coin_data', 'vesting_status'))
            {
                Schema::table('coin_data', function (Blueprint $table)
                {
                    $table->dropColumn('vesting_status');
                });
            }
            $table->longText('vesting_chart')->nullable()->default(null)->after('sparkline_in_7d');
            $table->boolean('vesting_status')->nullable()->default(0)->after('vesting_chart');
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
            //
        });
    }
};
