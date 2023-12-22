<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->enum('type', ['page','post','notification'])->default('page');
            $table->string('title_en');
            $table->string('title_ar');
            $table->text('description_en');
            $table->text('description_ar');
            $table->string('image_name')->nullable();
			// DI CODE - Start			
            $table->string('meta_keyword', 5000)->nullable();
            $table->text('meta_description')->nullable();
            $table->foreignId('user_id')->references('id')->on('users');
			// DI CODE - End
            $table->boolean('status')->default(1);
            $table->boolean('is_sent')->default(0);
			// DI CODE - Start
            $table->dateTime('post_date')->nullable();
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
        Schema::dropIfExists('posts');
    }
}
