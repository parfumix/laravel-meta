<?php

namespace Laravel\Meta\Eloquent;

use Eloquent\Translatable\Translatable;
use Eloquent\Translatable\TranslatableTrait;
use Illuminate\Database\Eloquent\Model;

class Meta extends Model implements Translatable {

    use TranslatableTrait;

    protected $table = 'meta_seo';

    public $timestamps = false;

    protected $fillable = ['metaable_id', 'metaable_type', 'key'];

    protected $translationClass = MetaTranslations::class;

    /**
     * Get all of the owning metaable models.
     */
    public function metaable() {
        return $this->morphTo();
    }
}