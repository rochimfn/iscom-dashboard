<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmittedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submitted', function (Blueprint $table) {
            $table->bigIncrements('submitted_id');
            $table->unsignedBigInteger('submitted_question_id');
            $table->unsignedBigInteger('submitted_team_id');
            $table->string('submitted_title');
            $table->string('submitted_file')->nullable();
            $table->string('submitted_competition_category_abbreviation');
            $table->timestamps();
        });

        Schema::table('submitted', function (Blueprint $table){
             $table->foreign('submitted_team_id')->references('team_id')->on('teams');
             $table->foreign('submitted_question_id')->references('question_id')->on('questions');
             $table->foreign('submitted_competition_category_abbreviation')->references('competition_category_abbreviation')->on('competition_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submitteds');
    }
}
