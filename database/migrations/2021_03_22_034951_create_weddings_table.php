<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weddings', function (Blueprint $table) {
            $table->id();
            $table->string('groom');
            $table->text('groom_description');
            $table->string('bride');
            $table->text('bride_description');
            $table->string('bride_instagram');
            $table->dateTime('reception_date');
            $table->text('reception_address');
            $table->dateTime('contract_date');
            $table->text('contract_address');
            $table->text('location');
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
        Schema::dropIfExists('weddings');
    }
}
