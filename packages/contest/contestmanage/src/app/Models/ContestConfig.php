<?php

namespace Contest\Contestmanage\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContestConfig extends Model {
    use SoftDeletes;
    protected $connection = 'mysql_vne';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contest_config';

    protected $primaryKey = 'config_id';

    protected $fillable = ['name'];

    protected $dates = ['deleted_at'];
}
