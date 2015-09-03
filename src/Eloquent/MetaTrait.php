<?php

namespace Laravel\Meta\Eloquent;

use Localization as Locale;

trait MetaSeoTrait {

    /**
     * Get meta ..
     *
     * @return mixed
     */
    public function meta() {
        return $this->morphMany(MetaSeoAble::class, 'metaable');
    }

    /**
     * Save meta
     *
     * @param array $meta
     * @return $this
     */
    public function storeMeta(array $meta = array()) {
        $this->meta->first()->fill($meta)->save();

        return $this;
    }

    /**
     * Check if is allowed use global placeholders .
     *
     * @return mixed
     */
    public function allowGlobalPlaceholders() {
        return $this['globalMetaPlaceholder'];
    }
}