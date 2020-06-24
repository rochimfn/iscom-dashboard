<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'questions';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'question_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['question_competition_category_id', 'question_title', 'question_description'];

}
