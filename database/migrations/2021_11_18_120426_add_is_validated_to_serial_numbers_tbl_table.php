<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsValidatedToSerialNumbersTblTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('serial_numbers_tbl', function (Blueprint $table) {
            $table->string('is_validated');
            $table->string('validate_count');
            $table->string('validated_on');
            $table->string('created_on');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('serial_numbers_tbl', function (Blueprint $table) {
            //
        });
    }
}
