<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSerialNumbersLogsTblTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serial_numbers_logs_tbl', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('serial_number_id');
            $table->unsignedBigInteger('site_id');
            $table->string('validated_on');
            $table->string('created_on');
            //$table->timestamps();

            $table->foreign('serial_number_id')->references('id')->on('serial_numbers_tbl')->onDelete('cascade');
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
        Schema::dropIfExists('serial_numbers_logs_tbl');
    }
}
