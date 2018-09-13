<?php

namespace Vne\Contact\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model {
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vne_contact';

    protected $primaryKey = 'contact_id';

    protected $fillable = ['name'];

    protected $dates = ['deleted_at'];
}
