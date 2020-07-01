<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submitted extends Model
{
        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'submitted';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'submitted_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['submitted_question_id','submitted_team_id', 'submitted_title', 'submitted_file', 'submitted_competition_category_abbreviation'];

    public function question()
    {
        return $this->belongsTo('App\Question', 'question_id', 'submitted_question_id');
    }
}
