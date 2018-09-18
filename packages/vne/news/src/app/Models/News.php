<?php

namespace Vne\News\App\Models;

use Illuminate\Database\Eloquent\Model;
use Vne\News\App\Models\NewsCat;
use Illuminate\Database\Eloquent\SoftDeletes;
class News extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vne_news';

    protected $primaryKey = 'news_id';
    protected static $cat;
    protected $guarded = ['news_id'];
    protected $dates = ['deleted_at'];
    
    
    public function getCats() {
        return $this->belongsToMany('Vne\News\App\Models\NewsCat', 'vne_news_has_cat', 'news_id', 'news_cat_id');
    }

    public function getTags() {
        return $this->belongsToMany('Vne\News\App\Models\NewsTag', 'vne_news_has_tag', 'news_id', 'news_tag_id');
    }

    public function getBoxs() {
        return $this->belongsToMany('Vne\News\App\Models\NewsBox', 'vne_news_has_box', 'news_id', 'news_box_id');
    }
}
