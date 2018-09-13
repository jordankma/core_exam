<?php

namespace Vne\News\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class NewsCat extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'vne_news_cat';

    protected $primaryKey = 'news_cat_id';

    protected $guarded = ['news_cat_id'];
}
