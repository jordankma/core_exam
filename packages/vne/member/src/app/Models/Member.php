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

    // public function search($params){
    //     $q = Member::orderBy('member_id', 'desc');
    //     if (!empty($params['name']) && $params['name'] != null) {
    //         $q->where('name', 'like', '%' . $params['name'] . '%');
    //     }
    //     if (!empty($params['u_name']) && $params['u_name'] != null) {
    //         $q->where('u_name', 'like', '%' . $params['u_name'] . '%');
    //     }
    //     if (!empty($params['table_id']) && $params['table_id'] != null) {
    //         $q->where('table_id',$params['table_id']);
    //     }
    //     if (!empty($params['city_id']) && $params['city_id'] != null) {
    //         $q->where('city_id',$params['city_id']);
    //     }
    //     if (!empty($params['district_id']) && $params['district_id'] != null) {
    //         $q->where('district_id',$params['district_id']);
    //     }
    //     if (!empty($params['school_id']) && $params['school_id'] != null) {
    //         $q->where('school_id',$params['school_id']);
    //     }
    //     if (!empty($params['class_id']) && $params['class_id'] != null) {
    //         $q->where('class_id', 'like', '%' . $params['class_id'] . '%');
    //     }
    //     $data = $q->with('city','school','district','classes')->where('is_reg',1)->paginate(20); 
    //     return $data;
    // }
}