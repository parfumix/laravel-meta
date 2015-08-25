<?php

namespace Laravel\Meta;

use Illuminate\Support\Facades\Facade;

class MetaFacade extends Facade {

    public static function getFacadeAccessor() {
        return 'meta';
    }
}