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
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->char('model')->nullable();
            $table->char('serial')->nullable(); //serial_number
            $table->char('serial_monitor')->nullable(); //monitor_serial_number
            $table->unsignedBigInteger('type_id')->nullable();
            $table->unsignedBigInteger('slot_one_ram_id')->nullable();
            $table->unsignedBigInteger('slot_two_ram_id')->nullable();
            $table->unsignedBigInteger('storage_id')->nullable();
            $table->char('cpu')->nullable();
            $table->ipAddress('ip', 15);
            $table->macAddress('mac');
            $table->char('anydesk')->nullable();
            $table->char('pc_name')->nullable();
            $table->char('pc_image')->nullable();
            $table->char('campu_id', 4)->nullable();
            $table->text('location')->nullable();
            $table->text('observation')->nullable();
            $table->uuid('rowguid')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->softDeletes();
            $table->smallInteger('deleted_at_status')->default(1)->nullable();
            $table->json('statu_id')->nullable();

            $table->foreign('campu_id')->references('id')->on('campus')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('type_id')->references('id')->on('types')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('brand_id')->references('id')->on('brands')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('slot_one_ram_id')->references('id')->on('slot_one_rams')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('slot_two_ram_id')->references('id')->on('slot_two_rams')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('storage_id')->references('id')->on('storages')->nullOnDelete()->cascadeOnUpdate();
            //$table->foreign('statu_id')->references('id')->on('status_computers_codes')->nullOnDelete()->cascadeOnUpdate();
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
