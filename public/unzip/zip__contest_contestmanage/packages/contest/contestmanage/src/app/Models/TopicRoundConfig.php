<?php

namespace Contest\Contestmanage\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TopicRoundConfig extends Model {
    use SoftDeletes;
    protected $connection = 'mysql_cuocthi';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'topic_round_config';

    protected $primaryKey = 'topic_round_config_id';

    protected $dates = ['deleted_at'];
}
