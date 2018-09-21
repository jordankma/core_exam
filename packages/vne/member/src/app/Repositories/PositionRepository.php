<?php

namespace Vne\Member\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Vne\Member\Repositories
 */
class PositionRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Vne\Member\App\Models\Position';
    }

    public function findAll() {

        DB::statement(DB::raw('set @rownum=0'));
        $result = $this->model::query();
        $result->select('vne_position.*', DB::raw('@rownum  := @rownum  + 1 AS rownum'));

        return $result;
    }
}
