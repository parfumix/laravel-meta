<?php

use Terranet\Metaable\MetaManagerContract;

if(! function_exists('meta')) {

    /**
     * Return meta manager instance with attributes .
     *
     * @param array $attributes
     * @return mixed
     */
    function meta(array $attributes = array()) {
        return app(MetaManagerContract::class)
            ->fromArray($attributes);
    }
}