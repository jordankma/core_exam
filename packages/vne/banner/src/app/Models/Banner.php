<?php

namespace Vne\Banner\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model {
	use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vne_banner';

    protected $primaryKey = 'banner_id';

    protected $guarded = ['banner_id'];
    protected $fillable = ['name'];
}