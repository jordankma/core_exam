<?php

namespace Vne\Banner\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use DB;
/**
 * Class DemoRepository
 * @package Vne\Banner\Repositories
 */
class PositionRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Vne\Banner\App\Models\Position';
    }
    public function findAll() {

        DB::statement(DB::raw('set @rownum=0'));
        $result = $this->model::query();
        $result->select('vne_banner_position.*', DB::raw('@rownum  := @rownum  + 1 AS rownum'));

        return $result;
    }
}
