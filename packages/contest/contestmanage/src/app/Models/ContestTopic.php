<?php

namespace Contest\Contestmanage\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContestTopic extends Model {
    use SoftDeletes;
    protected $connection = 'mysql_vne';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contest_topic';

    protected $primaryKey = 'topic_id';

    protected $fillable = ['topic_name'];

    protected $dates = ['deleted_at'];
}
