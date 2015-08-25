<?php

namespace Laravel\Meta\Eloquent;

interface Metaable {

    /**
     * Get meta title ..
     *
     * @param null $locale
     * @return mixed
     */
    public function getMetaTitle($locale = null);

    /**
     * Get meta description .
     *
     * @param null $locale
     * @return mixed
     */
    public function getMetaDescription($locale = null);

    /**
     * Get meta keywords ..
     *
     * @param null $locale
     * @return mixed
     */
    public function getMetaKeywords($locale = null);
}