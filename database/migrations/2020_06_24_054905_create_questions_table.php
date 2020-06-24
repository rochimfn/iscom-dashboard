<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('question_id');
            $table->unsignedBigInteger('question_competition_category_id');
            $table->string('question_title');
            $table->text('question_description');
            $table->timestamps();
        });
        Schema::table('questions', function (Blueprint $table){
             $table->foreign('question_competition_category_id')->references('competition_category_id')->on('competition_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
