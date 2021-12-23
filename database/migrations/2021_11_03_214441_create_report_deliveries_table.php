<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_deliveries', function (Blueprint $table) {
            $table->unsignedBigInteger('report_id');
            $table->string('name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('second_last_name');
            $table->string('position');
            $table->boolean('has_mouse')->default(0);
            $table->string('serial_mouse')->nullable();
            $table->boolean('has_keyboard')->default(0);
            $table->string('serial_keyboard')->nullable();
            $table->boolean('has_wifi')->default(0);
            $table->boolean('has_web_cam')->default(0);
            $table->boolean('has_power_charger')->default(0);
            $table->string('serial_power_charger')->nullable();
            $table->boolean('has_cover')->default(0);
            $table->boolean('has_briefcase')->default(0);
            $table->boolean('has_padlock')->default(0);
            $table->string('other_accesories')->nullable();

            $table->foreign('report_id')->references('id')->on('reports')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_deliveries');
    }
}
