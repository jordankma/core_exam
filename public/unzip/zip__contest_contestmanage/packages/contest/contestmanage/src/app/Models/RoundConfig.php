<?php

namespace Contest\Contestmanage\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoundConfig extends Model {
    use SoftDeletes;
    protected $connection = 'mysql_cuocthi';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'round_config';

    protected $primaryKey = 'round_config_id';

    protected $dates = ['deleted_at'];
}
