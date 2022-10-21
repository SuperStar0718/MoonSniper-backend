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
        Schema::table('user_columns', function (Blueprint $table) {
            if (Schema::hasColumn('user_columns', 'mode'))
            {
                Schema::table('user_columns', function (Blueprint $table)
                {
                    $table->dropColumn('mode');
                });
            }
            $table->string('mode')->nullable()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_columns', function (Blueprint $table) {
            //
        });
    }
};
