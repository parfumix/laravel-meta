<?php

namespace Laravel\Meta\Entity;

use Illuminate\Database\Eloquent\Model;

class MetaEloquent extends Model {

    protected $table = 'meta_seo';

    public $timestamps = false;

    protected $fillable = ['metaable_id', 'metaable_type', 'key', 'value'];

    /**
     * Get all of the owning metaable models.
     */
    public function metaable() {
        return $this->morphTo();
    }
}