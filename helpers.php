<?php

namespace Laravel\Meta;

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
