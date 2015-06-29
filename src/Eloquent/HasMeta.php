<?php

namespace Terranet\Metaable\Entity;

trait HasMeta {

    /**
     * Get meta ..
     *
     * @return mixed
     */
    public function meta() {
        return $this->morphMany(MetaEloquent::class, 'metaable');
    }

    /**
     * Get meta title .
     *
     */
    public function getMetaTitle() {
        return $this->meta()
            ->where('key', 'title')
            ->first();
    }

    /**
     * Get meta description .
     *
     * @return mixed
     */
    public function getMetaDescription() {
        return $this->meta()
            ->where('key', 'description')
            ->first();
    }

    /**
     * Get meta keywords ..
     *
     * @return mixed
     */
    public function getMetaKeywords() {
        return $this->meta()
            ->where('key', 'keywords')
            ->first();
    }
}