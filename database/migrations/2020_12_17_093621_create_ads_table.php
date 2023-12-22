<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();			
			// DI CODE - Start
			$table->string('ad_title');
			$table->string('slug');
			$table->text('ad_description');
			$table->integer('ad_category_id')->nullable();
			$table->integer('ad_sub_category_id')->nullable();
			$table->integer('ad_brand_id')->nullable();
			$table->enum('ad_condition', ['new','used'])->default('new');
			$table->decimal('ad_price', $precision = 12, $scale = 3)->nullable();
			$table->enum('ad_is_negotiable', ['0', '1'])->default('0');
			$table->string('ad_location_area_cat')->nullable();			
			$table->string('ad_location_area')->nullable();			
			$table->integer('ad_user_id');
			$table->string('ad_seller_name');
			$table->string('ad_seller_email')->nullable();
			$table->string('ad_seller_phone');
			$table->string('ad_seller_whatsapp')->nullable();
			$table->string('ad_seller_address', '1500')->nullable();
			$table->integer('ad_views')->nullable();
			$table->enum('ad_is_featured', ['0', '1'])->default('0');
			$table->enum('ad_priority', ['0', '1'])->default('0');
			//$table->enum('ad_status', ['0', '1'])->default('0');
			$table->boolean('status')->default(1);
			$table->softDeletes();
			// DI CODE - End			
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
        Schema::dropIfExists('ads');
    }
}
