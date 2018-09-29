<?php

namespace Contest\Contestmanage\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contest extends Model {
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $connection = 'msql_dhcd';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'toolquiz_contest';

    protected $primaryKey = 'contest_id';

    protected $fillable = ['name'];

}
