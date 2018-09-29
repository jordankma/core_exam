<?php

namespace Contest\Contestmanage\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContestRound extends Model {
    use SoftDeletes;
    protected $connection = 'mysql_vne';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contest_round';

    protected $primaryKey = 'round_id';

    protected $fillable = ['round_name'];

    protected $dates = ['deleted_at'];
}
