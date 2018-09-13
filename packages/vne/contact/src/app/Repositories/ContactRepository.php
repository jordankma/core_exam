<?php

namespace Vne\Contact\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class ContactRepository
 * @package Vne\Contact\Repositories
 */
class ContactRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Vne\Contact\App\Models\Contact';
    }

    public function findAll() {

        $result = $this->model::query();
        return $result;
    }
}
