<?php

use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRendererFactory;
use Psr\Container\ContainerInterface;

use function DI\get;

return [
    //database default config 
    'database.host' => 'localhost',
    'database.username' => 'root',
    'database.password' => 'root',
    'database.name' => 'CTM_database',
    'dbsqlsrv.dsn' => '',
    'dbsqlsrv.user' => "",
    'dbsqlsrv.password' => "",

    'view.path' => dirname(__DIR__) . '/views',
    'twig.extensions' => [
        DI\get(\Framework\Router\RouterTwigExtension::class)
    ],
    // 'Router' => DI\create(\Framework\Router::class),
    Framework\Router::class => \DI\object(),
    RendererInterface::class => \DI\Factory(TwigRendererFactory::class),
    \PDO::class => function (ContainerInterface $c) {
        return new PDO($c->get('dbsqlsrv.dsn'), $c->get('dbsqlsrv.user'), $c->get('dbsqlsrv.password'), [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }

];
