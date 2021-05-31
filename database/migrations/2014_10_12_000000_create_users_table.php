<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('cc')->unique();
            $table->string('name', 56);
            $table->string('middle_name', 56)->nullable();
            $table->string('last_name', 56);
            $table->string('second_last_name')->nullable();
            $table->string('nick_name', 12);
            $table->date('age');
            $table->char('sex', 1);
            $table->string('phone_number', 20)->nullable();
            $table->string('optional_phone_number', 20)->nullable();
            $table->string('avatar')->nullable();
            $table->string('email', 120)->unique();
            $table->string('password');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->softDeletes();
            $table->dateTime('current_sign_in_at')->nullable();
            $table->dateTime('last_sign_in_at')->nullable();
            $table->boolean('is_active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
