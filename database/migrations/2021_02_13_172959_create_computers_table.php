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
            $table->string('monitor_serial_number')->nullable();
            $table->unsignedBigInteger('type_device_id')->nullable();
            $table->unsignedBigInteger('slot_one_ram_id')->nullable();
            $table->unsignedBigInteger('slot_two_ram_id')->nullable();
            $table->unsignedBigInteger('first_storage_id')->nullable();
            $table->unsignedBigInteger('second_storage_id')->nullable();
            $table->unsignedBigInteger('processor_id')->nullable();
            $table->string('pc_name_domain', 20)->nullable();
            $table->string('anydesk')->nullable();
            $table->string('pc_name')->nullable()->unique();
            $table->string('pc_image')->nullable();
            $table->uuid('rowguid')->nullable();

            //$table->foreign('id')->references('device_id')->on('devices')->nullOnDelete()->cascadeOnUpdate();
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
