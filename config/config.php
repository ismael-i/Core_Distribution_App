<?php

use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRendererFactory;
use Psr\Container\ContainerInterface;

return [
    'view.path' => dirname(__DIR__) . '/views',
    'twig.extensions' => [
        DI\get(\Framework\Router\RouterTwigExtension::class)
    ],
    // 'Router' => DI\create(\Framework\Router::class),
    Framework\Router::class => \DI\object(),
    RendererInterface::class => \DI\Factory(TwigRendererFactory::class)

];
