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
            $table->string('start_long');
            $table->string('start_lat');
            $table->string('finish_long');
            $table->string('finish_lat');
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
