<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Unique;

class CreateComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('components', function (Blueprint $table) {
            //$table->id();
            $table->unsignedBigInteger('device_id')->nullable();
            $table->unsignedBigInteger('type_device_id')->nullable();
            $table->string('monitor_serial_number')->nullable();
            $table->unsignedBigInteger('slot_one_ram_id')->nullable();
            $table->unsignedBigInteger('slot_two_ram_id')->nullable();
            $table->unsignedBigInteger('first_storage_id')->nullable();
            $table->unsignedBigInteger('second_storage_id')->nullable();
            $table->unsignedBigInteger('processor_id')->nullable();
            $table->boolean('handset')->nullable();
            $table->boolean('power_adapter')->nullable();

            $table->foreign('device_id')->references('id')->on('devices')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('type_device_id')->references('id')->on('type_devices')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('slot_one_ram_id')->references('id')->on('memory_rams')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('slot_two_ram_id')->references('id')->on('memory_rams')->OnDelete('no action')->OnUpdate('no action');
            $table->foreign('first_storage_id')->references('id')->on('storages')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('second_storage_id')->references('id')->on('storages')->OnDelete('no action')->OnUpdate('no action');
            $table->foreign('processor_id')->references('id')->on('processors')->cascadeOnDelete()->cascadeOnUpdate();
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
