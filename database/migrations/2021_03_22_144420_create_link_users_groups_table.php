<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLinkUsersGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_users_groups', function (Blueprint $table) {
            $table->integer('id_group');
            $table->foreign('id_group')->references('groups')->on('id');
            $table->integer('id_member');
            $table->foreign('id_member')->references('users')->on('id');
            //DB::statement('ALTER TABLE link_users_groups ADD CONSTRAINT pk PRIMARY KEY (id_group, id_member)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('link_users_groups');
    }
}
