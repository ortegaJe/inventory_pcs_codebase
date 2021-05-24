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
            $table->string('batch', 20)->nullable();
            $table->string('inventory_code_number', 12)->nullable()->unique();
            $table->string('inventory_active_code', 15)->nullable()->unique();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->char('model')->nullable();
            $table->char('serial_number')->unique();
            $table->char('monitor_serial_number')->nullable()->unique();
            $table->unsignedBigInteger('type_device_id')->nullable();
            $table->unsignedBigInteger('slot_one_ram_id')->nullable();
            $table->unsignedBigInteger('slot_two_ram_id')->nullable();
            $table->unsignedBigInteger('first_storage_id')->nullable();
            $table->unsignedBigInteger('second_storage_id')->nullable();
            $table->char('cpu')->nullable();
            $table->ipAddress('ip', 15)->nullable()->unique();
            $table->macAddress('mac')->nullable()->unique();
            $table->char('pc_name_domain', 20)->nullable();
            $table->char('anydesk')->nullable()->unique();
            $table->char('pc_name')->nullable()->unique();
            $table->char('pc_image')->nullable();
            $table->char('campu_id', 7)->nullable();
            $table->text('location')->nullable();
            $table->date('custodian_assignment_date')->nullable();
            $table->string('custodian_name', 56)->nullable();
            $table->text('observation')->nullable();
            $table->uuid('rowguid')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->softDeletes();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('statu_id')->nullable();

            $table->foreign('campu_id')->references('id')->on('campus')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('type_device_id')->references('id')->on('type_devices')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('brand_id')->references('id')->on('brands')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('slot_one_ram_id')->references('id')->on('slot_one_rams')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('slot_two_ram_id')->references('id')->on('slot_two_rams')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('first_storage_id')->references('id')->on('first_storages')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('second_storage_id')->references('id')->on('second_storages')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('statu_id')->references('id')->on('statu_computer_codes')->nullOnDelete()->cascadeOnUpdate();
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
