<?php

use App\Store\StoreModule;

return [
    'store.prefix' => '/store',
    StoreModule::class => \DI\object()->constructorParameter('prefix', \DI\get('store.prefix'))
];
