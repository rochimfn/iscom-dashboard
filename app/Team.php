<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'teams';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'team_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'team_name', 'team_competition_category_id'
    ];

    public function mahasiswa()
    {
        return $this->hasMany('App\Mahasiswa', 'mahasiswa_team_id',  'team_id');
    }

    public function user()
    {
        // The first argument is the name of the final model we wish to access,
        // the second argument is the name of the intermediate model.
        // The third argument is the name of the foreign key on the intermediate model.
        // The fourth argument is the name of the foreign key on the final model.
        // The fifth argument is the local key, while
        // the sixth argument is the local key of the intermediate model:

        return $this->hasManyThrough(
            'App\User', 
            'App\Mahasiswa', 
            'mahasiswa_team_id' ,
            'user_name', 
            'team_id',
            'mahasiswa_nrp'
            );
    }
}
