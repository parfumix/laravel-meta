<?php

namespace Terranet\Metaable;

interface MetaManagerContract {

    /**
     * Render meta ..
     *
     * @return $string
     */
    public function render();

    /**
     * Set meta ..
     *
     * @param $name
     * @param $value
     * @param bool $replace
     * @return $this
     */
    public function set($name, $value, $replace = true);

    /**
     * Get meta ..
     *
     * @param $name
     * @param string $default
     * @return $string
     */
    public function get($name, $default = '');
}