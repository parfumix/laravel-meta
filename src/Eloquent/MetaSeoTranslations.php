<?php

namespace Laravel\Meta\Eloquent;

use Illuminate\Database\Eloquent\Model;

class MetaSeoTranslations extends Model {

    protected $table = 'meta_seo_translations';

    public $fillable = ['meta_seo_id', 'language_id', 'title', 'description', 'keywords'];

    public $timestamps = false;
}
