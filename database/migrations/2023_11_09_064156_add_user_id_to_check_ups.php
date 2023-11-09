<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToCheckUps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('check_ups', function (Blueprint $table) {
            $table->unsignedBigInteger('nurse_id')->nullable();
            $table->foreign('nurse_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('check_ups', function (Blueprint $table) {
            $table->dropForeign(['nurse_id']);
            $table->dropColumn('nurse_id');
        });
    }
}
