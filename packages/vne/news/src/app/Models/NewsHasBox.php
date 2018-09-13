<?php

namespace Vne\News\App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsHasBox extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vne_news_has_box';

    protected $primaryKey = 'news_has_box_id';

    protected $guarded = ['news_has_box_id'];
}
