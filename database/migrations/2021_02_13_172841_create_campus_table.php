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
            $table->char('id', 7)->primary();
            $table->char('description')->unique();
            $table->char('address')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });

        Schema::create('campu_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->char('campu_id', 7)->nullable()->unique();
            $table->timestamp('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('campu_id')->references('id')->on('campus')->onDelete('set null')->onUpdate('cascade');
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
