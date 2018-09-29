<?php

namespace Contest\Contestmanage\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Exam\Exammanage\Repositories
 */
class ContestConfigRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Contest\Contestmanage\App\Models\ContestConfig';
    }

    public function findAll() {

        $result = $this->model::query();
        return $result;
    }
    public function findByType($type) {

        $result = $this->model::query()->where('config_type', $type);;
        return $result;
    }
}
