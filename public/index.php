<?php

use DI\ContainerBuilder;

require dirname(__DIR__) . "/vendor/autoload.php";

$modules = [
    App\Store\StoreModule::class
];
$builder = new ContainerBuilder();
$builder->addDefinitions(dirname(__DIR__) . '/config/config.php');

foreach ($modules as $module) {
    if ($module::DEFINITIONS) {
        $builder->addDefinitions($module::DEFINITIONS);
    }
}
$builder->addDefinitions(dirname(__DIR__) . '/config.php');
$container = $builder->build();

// $renderer = new Framework\Renderer\TwigRenderer(dirname(__DIR__) . '/views');
// $container->get(RendererInterface::class);


$app = new \Framework\App(
    $container,
    $modules
);

if (php_sapi_name() !== "cli") {
    $response = $app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());
    Http\Response\send($response);
}
