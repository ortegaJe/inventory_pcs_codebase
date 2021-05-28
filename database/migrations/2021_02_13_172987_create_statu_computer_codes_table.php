<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatuComputerCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statu_computer_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('statu_id');
            $table->unsignedBigInteger('pc_id');
            $table->timestamp('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();

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
        Schema::dropIfExists('statu_computer_codes');
    }
}
