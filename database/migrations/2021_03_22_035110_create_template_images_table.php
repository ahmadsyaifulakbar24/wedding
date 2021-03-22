<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_setting_id')->constrained('template_settings')->onUpdate('cascade')->onDelete('cascade');
            $table->string('type');
            $table->text('image');
            $table->integer('order');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('template_images');
    }
}
