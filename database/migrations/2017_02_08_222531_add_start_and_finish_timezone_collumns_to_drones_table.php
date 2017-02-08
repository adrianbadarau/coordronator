<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStartAndFinishTimezoneCollumnsToDronesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drones', function (Blueprint $table) {
            $table->string('start_timezone');
            $table->string('end_timezone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('drones', function (Blueprint $table) {
            $table->dropColumn('start_timezone');
            $table->dropColumn('end_timezone');
        });
    }
}
