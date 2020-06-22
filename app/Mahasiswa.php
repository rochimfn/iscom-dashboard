<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mahasiswa';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'mahasiswa_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mahasiswa_nrp', 'mahasiswa_name', 'mahasiswa_team_id','is_team_leader'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function user()
    {
        return $this->hasMany('App\User',  'user_name', 'mahasiswa_nrp');
    }
    public function team()
    {
        return $this->belongsTo('App\Team', 'mahasiswa_team_id', 'team_id');
    }
    public function category()
    {
        return $this->hasOneThrough(
            'App\CompetitionCategory',
            'App\Team',
            'team_id',
            'competition_category_id',
            'mahasiswa_team_id',
            'team_competition_category_id');
    }
}
