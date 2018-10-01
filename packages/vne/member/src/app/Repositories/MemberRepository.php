<?php

namespace Vne\Member\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;
use Vne\Member\App\Models\Member;
/**
 * Class DemoRepository
 * @package Vne\Member\Repositories
 */
class MemberRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Vne\Member\App\Models\Member';
    }

    public function deleteID($id) {
        return $this->model->where('member_id', '=', $id)->update(['visible' => 0]);
    }

    public function findAll() {

        DB::statement(DB::raw('set @rownum=0'));
        $result = $this->model::query()->with('getPosition');
        $result->select('vne_member.*', DB::raw('@rownum  := @rownum  + 1 AS rownum'));

        return $result;
    }

    public function search($params){
        $q = Member::orderBy('member_id', 'desc');
        if (!empty($params['name']) && $params['name'] != null) {
            $q->where('name', 'like', '%' . $params['name'] . '%');
        }
        if (!empty($params['u_name']) && $params['u_name'] != null) {
            $q->where('u_name', 'like', '%' . $params['u_name'] . '%');
        }
        if (!empty($params['table_id']) && $params['table_id'] != null) {
            $q->where('table_id',$params['table_id']);
        }
        if (!empty($params['city_id']) && $params['city_id'] != null) {
            $q->where('city_id',$params['city_id']);
        }
        if (!empty($params['district_id']) && $params['district_id'] != null) {
            $q->where('district_id',$params['district_id']);
        }
        if (!empty($params['school_id']) && $params['school_id'] != null) {
            $q->where('school_id',$params['school_id']);
        }
        if (!empty($params['class_id']) && $params['class_id'] != null) {
            $q->where('class_id', 'like', '%' . $params['class_id'] . '%');
        }
        $data = $q->with('city','school','district','classes')->where('is_reg',1)->paginate(20); 
        return $data;
    }
}
