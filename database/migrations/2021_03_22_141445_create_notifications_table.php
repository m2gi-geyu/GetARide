<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->integer('id')->unique()->autoIncrement();
            $table->integer('id_user');
            $table->foreign('id_user')->references('id')->on('users');
            $table->integer('id_user_origin');
            $table->foreign('id_user_origin')->references('id')->on('users');
            $table->integer('notification_type');
            $table->timestamp('notification_date');
            $table->text('text');
            $table->boolean('read')->default(false);
            $table->integer('id_trip');
            $table->foreign('id_trip')->references('id')->on('trips');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
