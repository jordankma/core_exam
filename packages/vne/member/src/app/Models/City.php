<?php

namespace Vne\Member\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model {
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vne_city';

    protected $primaryKey = 'city_id';

    protected $fillable = ['name'];

    protected $dates = ['deleted_at'];
}
