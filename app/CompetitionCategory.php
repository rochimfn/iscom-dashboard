<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompetitionCategory extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'competition_categories';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'competition_category_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'competition_category_name',
        'competition_category_abbreviation'
    ];

    public function team()
    {
        return $this->HasMany('App\Team', 'team_competition_category_id', 'competition_category_id');
    }
}
