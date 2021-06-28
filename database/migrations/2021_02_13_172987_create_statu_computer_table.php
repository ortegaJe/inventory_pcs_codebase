<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatuComputerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statu_computers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('statu_id');
            $table->unsignedBigInteger('pc_id');
            $table->timestamp('date_log')->nullable();

            $table->foreign('statu_id')->references('id')->on('status')->onDelete('no action')->onDelete('cascade');
            $table->foreign('pc_id')->references('id')->on('computers')->onDelete('no action')->onDelete('cascade');
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
