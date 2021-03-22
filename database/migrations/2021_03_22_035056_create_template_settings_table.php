<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wedding_id')->constrained('weddings')->onUpdate('cascade')->onDelete('cascade');
            $table->string('theme');
            $table->foreignId('category_id')->constrained('params')->onUpdate('cascade')->onDelete('cascade'); 
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
        Schema::dropIfExists('template_settings');
    }
}
