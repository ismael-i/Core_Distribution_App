<?php

namespace App\Store;

use App\Store\Actions\StoreAction;
use Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Router;

class StoreModule extends Module
{
    const DEFINITIONS = __DIR__ . '/config.php';
    private $renderer;


    public function __construct(string $prefix, Router $router, RendererInterface $renderer)
    {
        // $this->renderer = $renderer;
        $renderer->addPath('store', __DIR__ . '/views');
        $router->get($prefix, StoreAction::class, name: 'store.index');
        $router->get($prefix . '/{AR_Ref:[a-zA-Z0-9\-]+}', StoreAction::class, name: 'store.show');
    }
}
