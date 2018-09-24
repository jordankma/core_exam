<?php

namespace Vne\News\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use DB;
use Vne\News\App\Models\News;
/**
 * Class DemoRepository
 * @package Vne\News\Repositories
 */
class NewsRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Vne\News\App\Models\News';
    }

    public function findAll() {

        DB::statement(DB::raw('set @rownum=0'));
        $result = $this->model::query();
        $result->select('vne_news.*', DB::raw('@rownum  := @rownum  + 1 AS rownum'));

        return $result;
    }
    public static function getListNews($params) {
        DB::statement(DB::raw('set @rownum=0'));
        $q = News::orderBy('news_id', 'desc')->where('type_page','news');
        if (!empty($params['name']) && $params['name'] != null) {
            $q->where('title', 'like', '%' . $params['name'] . '%');
        }
        if (!empty($params['news_time']) && $params['news_time'] != null) {
            $fromDate = date($params['news_time'] . ' 00:00:00', time());
            $toDate = date($params['news_time'] . ' 23:59:59', time());
            $q->whereBetween('created_at', array($fromDate, $toDate));
        }
        if (!empty($params['is_hot']) && $params['is_hot'] != null) {
            $q->where('is_hot', $params['is_hot']);
        }
        if (!empty($params['news_cat']) && $params['news_cat'] != null) {
            $q->with('getCats')
            ->whereHas('getCats', function ($query) use ($params) {
                $query->where('vne_news_cat.news_cat_id', $params['news_cat']);
            });
        }
        if (!empty($params['news_box']) && $params['news_box'] != null) {
            $q->with('getBoxs')
            ->whereHas('getBoxs', function ($query) use ($params) {
                $query->where('vne_news_box.news_box_id', $params['news_box']);
            });
        }
        $data = $q->select('vne_news.*', DB::raw('@rownum  := @rownum  + 1 AS rownum'))->get(); 
        return $data;
    }

    public static function getListNewsApi($params) {
        $q = News::orderBy('news_id', 'desc');
        if (!empty($params['keyword']) && $params['keyword'] != null) {
            $q->where('title', 'like', '%' . $params['keyword'] . '%');
        }
        if (!empty($params['news_cat_id']) && $params['news_cat_id'] != null) {
            $q->with('getCats')
            ->whereHas('getCats', function ($query) use ($params) {
                $query->whereIn('vne_news_cat.news_cat_id', $params['news_cat_id']);
            });
        }
        if (!empty($params['news_tag_id']) && $params['news_tag_id'] != null) {
            $q->with('getTags')
            ->whereHas('getTags', function ($query) use ($params) {
                $query->whereIn('vne_news_tag.news_tag_id', $params['news_tag_id']);
            });
        }
        $data = $q->paginate(10); 
        return $data;
    }

    public function getNewsByBox($alias,$limit) {
        
        $result = News::orderBy('news_id', 'desc')->whereHas('getBoxs', function ($query) use ($alias) {
            $query->where('vne_news_box.alias', $alias);
        })->paginate($limit, ['*'], $alias);
        return $result;
    }

    public function getNewsByCate($alias,$limit) {
        
        $result = News::whereHas('getCats', function ($query) use ($alias) {
            $query->where('vne_news_cat.alias', $alias);
        })->paginate($limit, ['*'], $alias);
        return $result;
    }
}