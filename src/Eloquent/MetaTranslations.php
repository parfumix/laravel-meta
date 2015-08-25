<?php

namespace Laravel\Meta\Eloquent;

use Illuminate\Database\Eloquent\Model;

class MetaTranslations extends Model {

    public $fillable = ['meta_id', 'language_id', 'value'];

    public $timestamps = false;
}
