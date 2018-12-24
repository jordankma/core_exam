<?php

namespace Vne\Essay\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Vne\Essay\Repositories
 */
class EssayRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Vne\Essay\App\Models\Essay';
    }

    public function findAll() {

        $result = $this->model::query()->with('member','essayTopic');
        return $result;
    }
    public function search($params){
        $q = $this->model->orderBy('essay_id', 'desc');
        if (!empty($params['member_name']) && $params['member_name'] != null) {
            $q->where('member_name', 'like', '%' . $params['member_name'] . '%');
        }
        if (!empty($params['name']) && $params['name'] != null) {
            $q->where('name', 'like', '%' . $params['name'] . '%');
        }
        if (!empty($params['u_name']) && $params['u_name'] != null) {
            $q->where('u_name', $params['u_name']);
        }
        if (!empty($params['table_id']) && $params['table_id'] != null) {
            $q->where('table_id',$params['table_id']);
        }
        $data = $q->paginate(20); 
        return $data;
    }
}
