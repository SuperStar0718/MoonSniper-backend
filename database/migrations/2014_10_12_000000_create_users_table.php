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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fullName');
            $table->string('username')->unique();
            $table->string('contact')->nullable();
            $table->string('email')->unique();
            $table->string('company')->nullable();
            $table->string('country')->nullable();
            $table->string('role')->nullable();
            $table->string('currentPlan')->nullable();
            $table->string('status')->nullable();
            $table->string('avatar')->nullable();
            $table->dateTime('dob')->nullable();
            $table->string('website')->nullable();
            $table->string('language')->nullable();
            $table->string('gender')->nullable();
            $table->string('contactOptions')->nullable();
            $table->text('addressLine1')->nullable();
            $table->text('addressLine2')->nullable();
            $table->string('postcode')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
