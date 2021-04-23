<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusComputerCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_computers_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('statu_id')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();

            $table->foreign('statu_id')->references('id')->on('status_computers')->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status_computer_codes');
    }
}
