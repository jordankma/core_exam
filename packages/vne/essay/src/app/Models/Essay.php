<?php

namespace Vne\Essay\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Essay extends Model {
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vne_essay';

    protected $primaryKey = 'essay_id';

    protected $fillable = ['name'];

    protected $dates = ['deleted_at'];

    public function member(){
        return $this->hasOne('Vne\Member\App\Models\Member', 'member_id', 'member_id');
    }
    public function essayTopic(){
        return $this->hasOne('Vne\Essay\App\Models\EssayTopic', 'essay_topic_id', 'essay_topic_id');
    }

}
