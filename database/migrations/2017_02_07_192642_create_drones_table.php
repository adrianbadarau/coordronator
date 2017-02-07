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
            $table->float('start_long');
            $table->float('start_lat');
            $table->float('finish_long');
            $table->float('finish_lat');
            $table->dateTimeTz('start_time');
            $table->dateTimeTz('end_time');
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
