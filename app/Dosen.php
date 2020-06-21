<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dosen';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'dosen_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['dosen_name','user_id'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'user_id');
    }
}
