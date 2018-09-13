<?php

namespace Vne\Banner\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;
/**
 * Class DemoRepository
 * @package Vne\Banner\Repositories
 */
class BannerRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Vne\Banner\App\Models\Banner';
    }

    public function deleteID($id) {
        return $this->model->where('banner_id', '=', $id)->update(['visible' => 0]);
    }

    public function findAll() {

        DB::statement(DB::raw('set @rownum=0'));
        $result = $this->model::query();
        $result->select('vne_banner.*', DB::raw('@rownum  := @rownum  + 1 AS rownum'));

        return $result;
    }
}
