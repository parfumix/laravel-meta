<?php

namespace Laravel\Meta\Eloquent;

interface MetaSeoable {

    /**
     * Get meta .
     *
     * @return mixed
     */
    public function meta();

    /**
     * Check if is allowed use global placeholders .
     *
     * @return mixed
     */
    public function allowGlobalPlaceholders();
}