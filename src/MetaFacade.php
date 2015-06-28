<?php

namespace Terranet\Metaable;

use Illuminate\Support\Facades\Facade;

class MetaFacade extends Facade {

    public static function getFacadeAccessor() {
        return MetaManagerContract::class;
    }
}