<?php

namespace Framework;

use GuzzleHttp\Psr7\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{
    private $modules = [];

    /**
     * @var ContainerInterface
     *
     */

    private $container;


    /**
     * @param string[] $modules Liste des modules
     */
    public function __construct(ContainerInterface $container, array $modules = [])
    {
        // $this->router = new Router;
        // if (array_key_exists('renderer', $dependencies)) {
        //     $dependencies['renderer']->addGlobal('router', $this->router);
        // }
        $this->container = $container;
        foreach ($modules as $module) {
            $this->modules[] = $container->get($module);
        }
    }

    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $uri = $request->getUri()->getPath();
        $start = 0; // La position de début de découpe
        $length = -1; // La longueur de la sous-chaîne extraite
        $header = "Location";
        if (!empty($uri) && $uri[-1] === "/") {
            return $response = (new Response())
                ->withStatus(code: 301)
                ->withHeader($header, substr($uri, $start, $length));
        }

        $router = $this->container->get(Router::class);
        $route = $router->match($request);
        if (is_null($route)) {
            return new Response(status: 404, body: '<h1>404 error</h1>');
        }
        $params = $route->getParams();
        $request = array_reduce(array_keys($params), function ($request, $key) use ($params) {
            return $request->withAttribute($key, $params[$key]);
        }, $request);
        $callback = $route->getCallback();
        if (is_string($callback)) {
            $callback = $this->container->get($callback);
        }
        $response = call_user_func_array($callback, [$request]);


        if (is_string($response)) {
            return new Response(200, [], $response);
        } elseif ($response instanceof ResponseInterface) {
            return $response;
        } else {
            throw new \Exception("The reponse is not a string or an instance of ResponceInterface");
        }
    }
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }
}
