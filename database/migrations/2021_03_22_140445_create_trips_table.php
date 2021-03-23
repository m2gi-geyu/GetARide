<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->integer('id')->unique()->autoIncrement();
            $table->integer('id_driver')->unsigned();
            $table->foreign('id_driver')->references('id')->on('users');
            $table->integer('number_of_seats');
            $table->text('starting_town');
            $table->text('ending_town');
            $table->timestamp('date_trip');
            $table->float('price');
            $table->boolean('private')->default(false);
            $table->text('description');
            $table->integer('id_group')->unsigned();
            $table->foreign('id_group')->references('id')->on('groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips');
    }
}
