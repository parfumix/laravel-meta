<?php

namespace Terranet\Metaable\Entity;

interface Metaable {

    /**
     * Get meta title ..
     *
     * @return mixed
     */
    public function getMetaTitle();

    /**
     * Get meta description .
     *
     * @return mixed
     */
    public function getMetaDescription();

    /**
     * Get meta keywords ..
     *
     * @return mixed
     */
    public function getMetaKeywords();
}