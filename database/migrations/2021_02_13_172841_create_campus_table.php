<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campus', function (Blueprint $table) {
            $table->string('id', 4)->primary();
            $table->string('description')->unique();
            $table->string('address')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
        });

        Schema::create('campu_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('campus_id', 4)->nullable()->unique();
            $table->dateTime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('campus_id')->references('id')->on('campus')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campus');
    }
}
