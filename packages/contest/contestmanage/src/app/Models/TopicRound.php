<?php

namespace Contest\Contestmanage\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TopicRound extends Model {
    use SoftDeletes;
    protected $connection = 'mysql_vne';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'topic_round';

    protected $primaryKey = 'topic_round_id';

    protected $fillable = ['topic_round_name'];

    protected $dates = ['deleted_at'];
}
