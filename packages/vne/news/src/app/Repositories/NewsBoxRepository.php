<?php

namespace Vne\News\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;
/**
 * Class DemoRepository
 * @package Vne\News\Repositories
 */
class NewsBoxRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Vne\News\App\Models\NewsBox';
    }

    public function findAll() {

        DB::statement(DB::raw('set @rownum=0'));
        $result = $this->model::query();
        $result->select('vne_news_box.*', DB::raw('@rownum  := @rownum  + 1 AS rownum'));

        return $result;
    }
}