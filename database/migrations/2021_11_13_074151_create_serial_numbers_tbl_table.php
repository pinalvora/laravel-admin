<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSerialNumbersTblTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serial_numbers_tbl', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number');
            $table->unsignedBigInteger('site_id');
            $table->timestamps();

            $table->foreign('site_id')->references('id')->on('sites_tbl')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('serial_numbers_tbl');
    }
}
