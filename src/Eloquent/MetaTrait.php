<?php

namespace Laravel\Meta\Eloquent;

use Localization as Locale;

trait MetaTrait {

    /**
     * Get meta ..
     *
     * @return mixed
     */
    protected function meta() {
        return $this->morphMany(Meta::class, 'metaable');
    }

    /**
     * Get meta by key .
     *
     * @param $key
     * @param null $locale
     * @return string
     */
    public function getMeta($key, $locale = null) {
        $meta = $this->meta()
            ->where('key', $key)
            ->first();

        $locale = isset($locale) ? $locale : Locale\get_active_locale();

        return ! is_null($meta) ? $meta->translate($locale)->value : '';
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