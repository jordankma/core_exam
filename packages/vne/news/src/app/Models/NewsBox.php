<?php

namespace Vne\News\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class NewsBox extends Model
{
   /**
     * The database table used by the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'vne_news_box';

    protected $primaryKey = 'news_box_id';

    protected $guarded = ['box_id'];
    protected $fillable = ['name'];
}
