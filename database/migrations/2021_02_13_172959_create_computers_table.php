<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComputersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('computers', function (Blueprint $table) {
            $table->id();
            $table->string('batch', 10)->nullable();
            $table->string('inv_code', 10)->nullable()->unique();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->string('model')->nullable();
            $table->string('serial')->unique();
            $table->string('serial_monitor')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->unsignedBigInteger('ram_slot_0_id')->nullable();
            $table->unsignedBigInteger('ram_slot_1_id')->nullable();
            $table->unsignedBigInteger('hdd_id')->nullable();
            $table->char('campu_id',4)->nullable();
            $table->string('cpu')->nullable();
            $table->ipAddress('ip',15)->unique();
            $table->macAddress('mac')->unique();
            //$table->string('os')->nullable();
            $table->string('anydesk')->nullable()->unique();
            $table->string('pc_name')->nullable()->unique();
            $table->string('image')->nullable();
            $table->text('location')->nullable();
            $table->text('observation')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->softDeletes();
            $table->smallInteger('deleted_at_status')->default(1)->nullable();
            $table->unsignedBigInteger('status_id')->default(1)->nullable();

            $table->foreign('campu_id')->references('id')->on('campus')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('type_id')->references('id')->on('types')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('ram_slot_0_id')->references('id')->on('rams')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('ram_slot_1_id')->references('id')->on('rams');
            $table->foreign('hdd_id')->references('id')->on('hdds')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('computers');
    }
}
