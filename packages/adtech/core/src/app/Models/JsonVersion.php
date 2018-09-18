<?php

namespace Adtech\Core\App\Models;

use Illuminate\Database\Eloquent\Model;

class JsonVersion extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $connection = 'mysql_core';

    protected $table = 'adtech_core_json_version';

    protected $primaryKey = 'id';

    protected $guarded = ['id'];

    protected $fillable = ['json_id', 'version', 'locale'];
}
