<?php

namespace Adtech\Core\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;

class JsonRepository extends Repository
{
    /**
     * @return string
     */
    public function model()
    {
        return 'Adtech\Core\App\Models\Json';
    }

    public function findAll($domain_id = 0, $locale = 'vi') {
        $result = $this->model::query();
        $result->where('domain_id', $domain_id);
//        $result->with('version')
//            ->whereHas('version', function ($query) use ($locale) {
//                $query->where('adtech_core_json_version.locale', $locale);
//            });
        return $result;
    }
}
