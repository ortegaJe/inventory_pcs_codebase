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
            $table->string('inventory_code_number', 12)->unique();
            $table->string('inventory_active_code', 15)->nullable()->unique();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->char('model')->nullable();
            $table->char('serial_number')->unique();
            $table->char('monitor_serial_number')->nullable();
            $table->unsignedBigInteger('type_device_id')->nullable();
            $table->unsignedBigInteger('slot_one_ram_id')->nullable();
            $table->unsignedBigInteger('slot_two_ram_id')->nullable();
            $table->unsignedBigInteger('first_storage_id')->nullable();
            $table->unsignedBigInteger('second_storage_id')->nullable();
            $table->unsignedBigInteger('processor_id')->nullable();
            $table->ipAddress('ip', 15)->nullable()->unique();
            $table->macAddress('mac')->nullable()->unique();
            $table->char('nat')->nullable();
            $table->char('pc_name_domain', 20)->nullable();
            $table->char('anydesk')->nullable();
            $table->char('pc_name')->nullable()->unique();
            $table->unsignedBigInteger('statu_id')->nullable();
            $table->char('pc_image')->nullable();
            $table->unsignedBigInteger('campu_id')->nullable();
            $table->text('location')->nullable();
            $table->date('custodian_assignment_date')->nullable();
            $table->string('custodian_name', 56)->nullable();
            $table->unsignedBigInteger('assignment_statu_id')->nullable();
            $table->text('observation')->nullable();
            $table->uuid('rowguid')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->softDeletes();
            $table->boolean('is_active')->default(true);

            $table->foreign('campu_id')->references('id')->on('campus')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('type_device_id')->references('id')->on('type_devices')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('brand_id')->references('id')->on('brands')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('slot_one_ram_id')->references('id')->on('memory_rams')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('slot_two_ram_id')->references('id')->on('memory_rams')->OnDelete('no action')->OnUpdate('no action');
            $table->foreign('first_storage_id')->references('id')->on('storages')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('second_storage_id')->references('id')->on('storages')->OnDelete('no action')->OnUpdate('no action');
            $table->foreign('processor_id')->references('id')->on('processors')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('statu_id')->references('id')->on('status')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('assignment_statu_id')->references('id')->on('status')->nullOnDelete()->cascadeOnUpdate();
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
