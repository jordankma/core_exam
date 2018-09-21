<?php

namespace Vne\Member\App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Member extends Model implements AuthenticatableContract, CanResetPasswordContract{
    use Authenticatable, CanResetPassword, Notifiable, SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $guard = "member";

    protected $table = 'vne_member';

    protected $primaryKey = 'member_id';

    protected $guarded = ['member_id'];

    protected $fillable = ['name', 'u_name', 'password',];

    protected $hidden = ['password', 'remember_token'];

    protected $dates = ['deleted_at'];

    // // Rest omitted for brevity

    // /**
    //  * Get the identifier that will be stored in the subject claim of the JWT.
    //  *
    //  * @return mixed
    //  */
    // public function getJWTIdentifier()
    // {
    //     return $this->getKey();
    // }

    // /**
    //  * Return a key value array, containing any custom claims to be added to the JWT.
    //  *
    //  * @return array
    //  */
    // public function getJWTCustomClaims()
    // {
    //     return [];
    // }

    public function getPosition(){
        return $this->hasOne('Dhcd\Member\App\Models\Position', 'position_id', 'position_id');
    }

    public function group(){
        return $this->belongsToMany('Dhcd\Member\App\Models\Group', 'dhcd_group_has_member', 'member_id', 'group_id');    
    }

    public function documentCate(){
        return $this->belongsToMany('Dhcd\Document\App\Models\DocumentCate', 'dhcd_document_cate_has_member', 'member_id', 'document_cate_id');
    }
}