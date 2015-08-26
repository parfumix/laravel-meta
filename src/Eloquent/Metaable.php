<?php

namespace Laravel\Meta\Eloquent;

interface Metaable {

    /**
     * Get meta by key.
     *
     * @param $key
     * @param null $locale
     * @return mixed
     */
    public function getMeta($key, $locale = null);

    /**
     * Check if is allowed use global placeholders .
     *
     * @return mixed
     */
    public function allowGlobalPlaceholders();
}