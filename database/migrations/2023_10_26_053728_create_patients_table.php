<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gender');
            $table->date('dob');
            $table->string('phone_number');
            $table->string('id_number')->unique();
            $table->string('email')->nullable();
            $table->string('next_of_kin_name');
            $table->string('next_of_kin_phone');
            $table->string('next_of_kin_relationship');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
