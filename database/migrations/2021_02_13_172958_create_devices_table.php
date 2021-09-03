<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('inventory_code_number', 12)->unique();
            $table->string('batch', 20)->nullable();
            $table->string('fixed_asset_number', 15)->nullable();
            $table->unsignedBigInteger('device_id')->nullable();
            $table->unsignedBigInteger('type_device_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->unique();
            $table->ipAddress('ip', 15)->nullable()->unique();
            $table->macAddress('mac')->nullable()->unique();
            $table->string('nat')->nullable();
            $table->unsignedBigInteger('campu_id')->nullable();
            $table->text('location');
            $table->unsignedBigInteger('statu_id')->nullable();
            $table->date('custodian_assignment_date');
            $table->string('custodian_name', 56);
            $table->unsignedBigInteger('assignment_statu_id')->nullable();
            $table->text('observation')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->softDeletes();
            $table->boolean('is_active')->default(true);

            $table->foreign('campu_id')->references('id')->on('campus')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('statu_id')->references('id')->on('status')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('assignment_statu_id')->references('id')->on('status')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('type_device_id')->references('id')->on('type_devices')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('brand_id')->references('id')->on('brands')->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
}
