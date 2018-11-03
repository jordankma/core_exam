<?php

namespace Vne\Essay\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Vne\Essay\Repositories
 */
class EssayTopicRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Vne\Essay\App\Models\EssayTopic';
    }

    public function findAll() {

        $result = $this->model::query();
        return $result;
    }
}
