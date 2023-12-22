<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')->nullable()->default(0);
            $table->string('name_en');
            $table->string('name_ar');
			// DI CODE - Start
            $table->string('slug');
			// DI CODE - End
            $table->string('image')->nullable();
            $table->string('banner_image')->nullable();			
			// DI CODE - Start
            $table->string('slide_image')->nullable();			
			// DI CODE - End
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
        Schema::dropIfExists('categories');
    }
}
