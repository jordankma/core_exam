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

    public function city(){
        return $this->hasOne('Vne\Member\App\Models\City', 'city_id', 'city_id');
    }

    public function district(){
        return $this->hasOne('Vne\Member\App\Models\District', 'district_id', 'district_id');
    }
    
    public function school(){
        return $this->hasOne('Vne\Member\App\Models\School', 'school_id', 'school_id');
    }
    
    public function classes(){
        return $this->hasOne('Vne\Member\App\Models\Classes', 'class_id', 'class_id');
    }

    public function table(){
        return $this->hasOne('Vne\Member\App\Models\Table', 'table_id', 'table_id');
    }

    public function object(){
        return $this->hasOne('Vne\Member\App\Models\Object', 'object_id', 'object_id');
    }
}