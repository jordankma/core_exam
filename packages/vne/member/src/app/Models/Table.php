<?php

namespace Vne\Member\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends Model {
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vne_table';

    protected $primaryKey = 'table_id';

    protected $fillable = ['name'];

    protected $dates = ['deleted_at'];
}
