<?php

namespace App\Store\Actions;

use Framework\Renderer\RendererInterface;
use Framework\Router;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class StoreAction
{
    private $renderer;
    /**
     * __construct
     *
     * @param  mixed $renderer
     * @param  mixed $pdo
     * @return void
     */


    private $pdo;
    private $router;

    public function __construct(RendererInterface $renderer, \PDO $pdo, Router $router)
    {
        $this->renderer = $renderer;
        $this->pdo = $pdo;
        $this->router = $router;
    }
    public function __invoke(Request $request)
    {
        if ($request->getAttribute('AR_Ref')) {
            return $this->show($request);
        } else {
            return $this->index();
        }
    }
    public function index(): string
    {
        $items = $this->pdo->query('SELECT * FROM F_ARTICLE')
            ->fetchAll();
        // var_dump($items);
        // die();
        return $this->renderer->render('@store/index', compact('items'));
    }


    public function show(Request $request): string
    {
        $AR_Ref = $request->getAttribute('AR_Ref');
        $query = $this->pdo
            ->prepare('SELECT * FROM F_ARTICLE WHERE AR_Ref =? ');
        $query->execute([$request->getAttribute('AR_Ref')]);
        $item = $query->fetch();


        // test si le nom de l'article correspond
        if ($item->AR_Ref !==  $AR_Ref) {
            $redirectUri = $this->router->generateUri('store.show', [
                'AR_Ref' => $item->AR_Ref
            ]);
            return (new Response())
                ->withStatus(301)
                ->withHeader('location', $redirectUri);
        }

        return $this->renderer->render('@store/show', compact('item'));
    }
}
