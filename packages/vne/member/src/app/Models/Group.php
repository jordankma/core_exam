<?php

namespace Vne\Member\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model {
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
    protected $table = 'vne_group';

    protected $primaryKey = 'group_id';

    protected $guarded = ['group_id'];
    
    protected $fillable = ['name'];

    public function getMember(){
        return $this->belongsToMany('Vne\Member\App\Models\Member', 'vne_group_has_member', 'group_id', 'member_id');
    }
}