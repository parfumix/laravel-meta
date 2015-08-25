<?php

namespace Laravel\Meta\Entity;

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
        $meta = $this->meta()
            ->where('key', 'title')
            ->first();

        return ! is_null($meta) ? $meta->value : '';
    }

    /**
     * Get meta description .
     *
     * @return mixed
     */
    public function getMetaDescription() {
        $meta = $this->meta()
            ->where('key', 'description')
            ->first();

        return ! is_null($meta) ? $meta->value : '';
    }

    /**
     * Get meta keywords ..
     *
     * @return mixed
     */
    public function getMetaKeywords() {
        $meta = $this->meta()
            ->where('key', 'keywords')
            ->first();

        return ! is_null($meta) ? $meta->value : '';
    }
}