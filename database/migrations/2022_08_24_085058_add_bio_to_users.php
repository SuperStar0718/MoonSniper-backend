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
        Schema::table('users', function (Blueprint $table) {
            $table->text('bio')->after('dob')->nullable();
            $table->string('notifications')->after('bio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'bio'))
            {
                Schema::table('users', function (Blueprint $table)
                {
                    $table->dropColumn('bio');
                });
            }
            if (Schema::hasColumn('users', 'notifications'))
            {
                Schema::table('users', function (Blueprint $table)
                {
                    $table->dropColumn('notifications');
                });
            }
        });
    }
};
