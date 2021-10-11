<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_code_number')->unique();
            $table->unsignedBigInteger('report_name_id')->nullable();
            $table->unsignedBigInteger('device_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->uuid('rowguid');
            $table->timestamp('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();

            //$table->foreign('report_name_id')->references('id')->on('report_names')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
