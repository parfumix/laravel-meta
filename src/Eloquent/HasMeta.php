<?php

namespace Laravel\Meta\Eloquent;

use Localization as Locale;

trait HasMeta {

    /**
     * Get meta ..
     *
     * @return mixed
     */
    protected function meta() {
        return $this->morphMany(Meta::class, 'metaable');
    }

    /**
     * Get meta title .
     * @param null $locale
     * @return string
     */
    public function getMetaTitle($locale = null) {
        $meta = $this->meta()
            ->where('key', 'title')
            ->first();

        $locale = isset($locale) ? $locale : Locale\get_active_locale();

        return ! is_null($meta) ? $meta->translate($locale)->value : '';
    }

    /**
     * Get meta description .
     *
     * @param null $locale
     * @return mixed
     */
    public function getMetaDescription($locale = null) {
        $meta = $this->meta()
            ->where('key', 'description')
            ->first();

        $locale = isset($locale) ? $locale : Locale\get_active_locale();

        return ! is_null($meta) ? $meta->translate($locale)->value : '';
    }

    /**
     * Get meta keywords ..
     *
     * @param null $locale
     * @return mixed
     */
    public function getMetaKeywords($locale = null) {
        $meta = $this->meta()
            ->where('key', 'keywords')
            ->first();

        $locale = isset($locale) ? $locale : Locale\get_active_locale();

        return ! is_null($meta) ? $meta->translate($locale)->value : '';
    }
}