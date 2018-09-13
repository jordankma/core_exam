<?php

namespace Vne\News\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;

/**
 * Class DemoRepository
 * @package Vne\News\Repositories
 */
class NewsHasCatRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Vne\News\App\Models\NewsHasCat';
    }
}