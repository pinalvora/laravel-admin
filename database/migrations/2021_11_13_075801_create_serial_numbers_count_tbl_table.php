<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSerialNumbersCountTblTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serial_numbers_count_tbl', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number');
            $table->unsignedBigInteger('site_id');
            $table->string('is_validated');
            $table->string('validate_count');
            $table->string('validate_on');
            $table->string('created_on');
            //$table->timestamps();
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
        Schema::dropIfExists('serial_numbers_count_tbl');
    }
}
