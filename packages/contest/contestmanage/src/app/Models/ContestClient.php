<?php

namespace Contest\Contestmanage\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContestClient extends Model {
    use SoftDeletes;
    protected $connection = 'mysql_vne';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contest_client';

    protected $primaryKey = 'client_id';

    protected $fillable = ['name'];

    protected $dates = ['deleted_at'];
}
