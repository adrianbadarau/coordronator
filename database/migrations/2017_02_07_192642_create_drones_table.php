<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDronesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_id', false, false);
            $table->index('type_id');
            $table->float('start_long', 8, 5);
            $table->float('start_lat', 7, 5);
            $table->float('finish_long', 8, 5)->nullable();
            $table->float('finish_lat', 7, 5)->nullable();
            $table->dateTimeTz('start_time')->nullable();
            $table->dateTimeTz('end_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('drones');
    }
}
