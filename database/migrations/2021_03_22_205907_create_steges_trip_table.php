<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStegesTripTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('steges_trip', function (Blueprint $table) {
            $table->integer('id_trip')->primary()->unsigned();
            $table->foreign('id_trip')->references('id')->on('trips');
            $table->text('stage');
            $table->integer('order');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('steges_trip');
    }
}
