<?php

namespace Laravel\Meta\Eloquent;

use Localization as Locale;

trait MetaTrait {

    /**
     * Get meta ..
     *
     * @return mixed
     */
    public function meta() {
        return $this->morphMany(MetaSeo::class, 'metaable');
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