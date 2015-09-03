<?php

namespace Laravel\Meta;

use Laravel\Meta\Eloquent\MetaSeoable;

/**
 * Return meta manager instance with attributes .
 *
 * @param array $attributes
 * @return mixed
 */
function meta(array $attributes = array()) {
    return app('meta')
        ->fromArray($attributes);
}

/**
 * Get meta manager from eloquent .
 *
 * @param MetaSeoable $metaable
 * @param null $locale
 * @return mixed
 */
function meta_eloquent(MetaSeoable $metaable, $locale = null) {
    return app('meta')
        ->fromEloquent($metaable, $locale);
}