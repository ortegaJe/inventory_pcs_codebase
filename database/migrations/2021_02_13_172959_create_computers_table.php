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
            $table->char('inv_code', 11)->nullable()->unique();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->char('model')->nullable();
            $table->char('serial')->unique();
            $table->char('serial_monitor')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->unsignedBigInteger('ram_slot_0_id')->nullable();
            $table->unsignedBigInteger('ram_slot_1_id')->nullable();
            $table->unsignedBigInteger('hdd_id')->nullable();
            $table->char('campu_id',4)->nullable();
            $table->char('cpu')->nullable();
            $table->ipAddress('ip',15)->unique();
            $table->macAddress('mac')->unique();
            $table->char('anydesk')->nullable()->unique();
            $table->char('pc_name')->nullable()->unique();
            $table->char('image')->nullable();
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
