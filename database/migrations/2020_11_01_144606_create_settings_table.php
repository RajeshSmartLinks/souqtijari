<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('sitename_en')->nullable();
            $table->string('sitename_ar')->nullable();
            $table->string('web_logo')->nullable();
			// DI CODE - Start
            $table->string('web_logo_ar')->nullable();
			// DI CODE - End
            $table->string('web_fav')->nullable();
            $table->integer('web_status')->default(1);
            $table->string('app_ios_url')->nullable();
            $table->string('app_android_url')->nullable();
            $table->string('host')->nullable();
            $table->string('port')->nullable();
            $table->string('email')->nullable();
            $table->string('smtp_password')->nullable();
            $table->string('from_name')->nullable();
            $table->string('smtp_encryption')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_mobile')->nullable();
            $table->string('contact_whatsapp')->nullable();
			// DI CODE - Start
            $table->string('contact_phone')->nullable();
            $table->string('contact_address')->nullable();
			// DI CODE - End
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->text('google_analytics')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
