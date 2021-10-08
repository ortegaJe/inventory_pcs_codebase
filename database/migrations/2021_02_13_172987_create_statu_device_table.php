<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatuDeviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statu_devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('statu_id');
            $table->unsignedBigInteger('device_id');
            $table->timestamp('date_log')->nullable();

            $table->foreign('statu_id')->references('id')->on('status')->onDelete('no action')->onDelete('cascade');
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statu_computers');
    }
}
