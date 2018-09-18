<?php

namespace Adtech\Core\App\Models;

use Illuminate\Database\Eloquent\Model;

class Json extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $connection = 'mysql_core';

    protected $table = 'adtech_core_json';

    protected $primaryKey = 'json_id';

    protected $guarded = ['json_id'];

    protected $fillable = ['name', 'path', 'domain_id'];

    public function domains()
    {
        return $this->hasMany('Adtech\Core\App\Models\Domain');
    }

    public function version()
    {
        return $this->hasMany('Adtech\Core\App\Models\JsonVersion', 'json_id', 'json_id');
    }

    public function locale()
    {
        return $this->hasMany('Adtech\Core\App\Models\JsonLocale', 'json_id', 'json_id');
    }
}
