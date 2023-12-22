<?php
// DI CODE - Start
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads_images', function (Blueprint $table) {
            $table->id();
			$table->integer('ads_ad_id')->nullable;
			$table->integer('ads_user_id');
			$table->string('ads_image');
            $table->enum('is_feature', ['0','1'])->default('0');			
			$table->boolean('status')->default(1);
			$table->softDeletes();
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
        Schema::dropIfExists('ads_images');
    }
}
// DI CODE - End