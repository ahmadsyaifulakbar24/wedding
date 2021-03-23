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
            $table->string('order_name');
            $table->string('order_email');
            $table->string('order_phone_number');

            $table->string('groom_full_name');
            $table->string('groom_short_name');
            $table->string('groom_child_order');
            $table->string('groom_father_name');
            $table->string('groom_mother_name');
            $table->string('groom_instagram');

            $table->string('bride_full_name');
            $table->string('bride_short_name');
            $table->string('bride_child_order');
            $table->string('bride_father_name');
            $table->string('bride_mother_name');
            $table->string('bride_instagram');

            $table->dateTime('reception_date');
            $table->text('reception_address');
            $table->dateTime('contract_date');
            $table->text('contract_address');
            $table->text('location');

            $table->boolean('active')->default(false);
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
