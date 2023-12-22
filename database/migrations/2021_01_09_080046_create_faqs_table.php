<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
			// DI CODE - Start
			$table->string('faq_title_en');
			$table->string('faq_title_ar');
			$table->string('slug');
			$table->text('faq_description_en');
			$table->text('faq_description_ar');
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
        Schema::dropIfExists('faqs');
    }
}
