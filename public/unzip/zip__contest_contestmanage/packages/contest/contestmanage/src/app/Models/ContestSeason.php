<?php

namespace Contest\Contestmanage\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContestSeason extends Model {
    use SoftDeletes;
    protected $connection = 'mysql_cuocthi';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contest_season';

    protected $primaryKey = 'season_id';

    protected $fillable = ['name'];

    protected $dates = ['deleted_at'];
}
