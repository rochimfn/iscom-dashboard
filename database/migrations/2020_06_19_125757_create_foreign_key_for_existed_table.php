<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignKeyForExistedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('user_role_id')->references('role_id')->on('roles');
        });
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->foreign('mahasiswa_team_id')->references('team_id')->on('teams');
        });
        Schema::table('teams', function (Blueprint $table) {
            $table->foreign('team_competition_category_id')->references('competition_category_id')->on('competition_categories');
        });
        Schema::table('pages', function (Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('user_role_id');
            $table->dropForeign('user_id');
        });
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropForeign('mahasiswa_team_id');
        });
        Schema::table('teams', function (Blueprint $table) {
            $table->dropForeign('team_competition_category_id');
        });
    }
}
