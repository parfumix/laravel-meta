<?php

namespace Laravel\Meta\Eloquent;

use Localization as Locale;

trait MetaSeoTrait {

    /**
     * Get meta ..
     *
     * @return mixed
     */
    public function metaSeo() {
        return $this->morphMany(MetaSeo::class, 'metaable')
            ->first();
    }

    /**
     * Save meta
     *
     * @param array $meta
     * @return $this
     */
    public function storeSeo(array $meta = array()) {
        if(! $metaSeo = $this->metaSeo())
            $metaSeo = new MetaSeo([
                'metaable_id' => $this->id,
                'metaable_type' => $this->getMorphClass(),
            ]);

        $metaSeo
            ->fill($meta)
            ->save();

        return $this;
    }

    /**
     * Check if is allowed use global placeholders .
     *
     * @return mixed
     */
    public function allowGlobalPlaceholders() {
        return $this['globalMetaPlaceholder'];
    }
}