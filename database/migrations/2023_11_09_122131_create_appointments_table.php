<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('receptionist_id')->nullable();
            $table->unsignedBigInteger('checkup_id')->nullable();
            $table->unsignedBigInteger('diagnosis_id')->nullable();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->unsignedBigInteger('room_id')->nullable();
            $table->enum('status', ['pending', 'ongoing', 'completed'])->default('pending');
            $table->decimal('billing', 8, 2)->nullable();
            $table->timestamps();

            $table->foreign('receptionist_id')->references('id')->on('users')->onDelete('no action');
            $table->foreign('checkup_id')->references('id')->on('check_ups')->onDelete('no action')->onUpdate('no action');
            $table->foreign('diagnosis_id')->references('id')->on('diagnoses')->onDelete('no action')->onUpdate('no action');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
