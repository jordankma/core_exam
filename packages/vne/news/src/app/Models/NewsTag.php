<?php

namespace Vne\News\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class NewsTag extends Model
{
   /**
     * The database table used by the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'vne_news_tag';

    protected $primaryKey = 'news_tag_id';

    protected $guarded = ['tag_id'];
    protected $fillable = ['name'];
}
