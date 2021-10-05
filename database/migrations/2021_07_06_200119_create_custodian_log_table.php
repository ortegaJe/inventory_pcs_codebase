<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustodianLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custodian_log', function (Blueprint $table) {
            //$table->id();
            $table->unsignedBigInteger('device_id')->nullable();
            $table->char('custodian_name');
            $table->char('position', 56)->nullable();
            $table->char('location');
            $table->unsignedBigInteger('assignment_statu_id')->nullable();
            $table->timestamp('assignment_date')->nullable();

            $table->foreign('assignment_statu_id')->references('id')->on('status')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('device_id')->references('id')->on('devices')->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custodian_log');
    }
}
