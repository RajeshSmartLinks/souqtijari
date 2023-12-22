<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
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
            $table->string('device_token')->nullable();
            $table->string('device_type')->nullable();
            $table->string('name');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
			// DI CODE - Start
            //$table->string('email')->unique();
			$table->string('email')->nullable();
			// DI CODE - End
            $table->timestamp('email_verified_at')->nullable();
            $table->string('username')->nullable();
            $table->string('mobile')->nullable();
			// DI CODE - Start
            $table->string('mobile_otp')->nullable();
			// DI CODE - End
            $table->string('whatsapp')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->integer('country_id')->default(0);
            $table->string('gender')->nullable();
            $table->string('address', '1500')->nullable();
            $table->string('website')->nullable();
            $table->string('activation_code')->nullable();
            $table->enum('admin_type', ['admin', 'user'])->default('user');
            $table->string('firebase_id')->nullable();
            $table->string('fcm_token', '900')->nullable();
            $table->string('avatar')->nullable();
            $table->string('country_code')->nullable();
            $table->boolean('mobile_verify')->default(0);
            $table->boolean('new_user')->default(1);
            $table->boolean('status')->default(1);
            $table->timestamp('last_login')->nullable();
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
}
