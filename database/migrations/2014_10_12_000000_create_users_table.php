<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id')->unique()->autoIncrement()->unsigned();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('remember_token',100)->nullable();
            $table->string('password');
            $table->string('phone')->unique();
            $table->boolean('vehicle')->default(false);
            $table->float('ratings')->nullable();
            $table->text('profile_pic')->nullable();
            $table->text('name');
            $table->text('surname');
            //$table->date('birthdate')->nullable();
            $table->boolean('mail_notifications')->default(true);
            $table->text('gender');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
