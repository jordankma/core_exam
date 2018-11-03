<?php

namespace Vne\Essay\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Essay extends Model {
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vne_essay';

    protected $primaryKey = 'essay_id';

    protected $fillable = ['name'];

    protected $dates = ['deleted_at'];
}
