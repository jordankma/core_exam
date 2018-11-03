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

        $result = $this->model::query();
        return $result;
    }
}
