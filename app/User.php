<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name', 'email', 'password', 'user_role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function mahasiswa()
    {
        return $this->hasOne('App\Mahasiswa', 'mahasiswa_nrp', 'user_name');
    }

    public function dosen()
    {
        return $this->hasOne('App\Dosen', 'user_id', 'user_id');
    }

    public function team()
    {
        // The first argument is the name of the final model we wish to access,
        // the second argument is the name of the intermediate model.
        // The third argument is the name of the foreign key on the intermediate model.
        // The fourth argument is the name of the foreign key on the final model.
        // The fifth argument is the local key, while
        // the sixth argument is the local key of the intermediate model:

        return $this->hasOneThrough(
            'App\Team', 
            'App\Mahasiswa', 
            'mahasiswa_nrp' ,
            'team_id', 
            'user_name',
            'mahasiswa_team_id'
            );
    }
}
