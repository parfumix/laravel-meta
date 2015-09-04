<?php

namespace Laravel\Meta\Eloquent;

use Localization as Locale;

trait MetaSeoTrait {

    /**
     * Get meta ..
     *
     * @return mixed
     */
    public function metaSeo() {
        return $this->morphMany(MetaSeo::class, 'metaable');
    }

    /**
     * Save meta
     *
     * @param array $meta
     * @return $this
     */
    public function storeSeo(array $meta = array()) {
        $this->metaSeo->first()->fill($meta)->save();

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