<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemoryRamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memory_rams', function (Blueprint $table) {
            $table->id();
            $table->integer('size')->nullable();
            $table->char('storage_unit')->nullable();
            $table->char('type')->nullable();
            $table->char('format')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('memory_rams');
    }
}
