<?php

namespace App\Store\Actions;

use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface as Request;

class StoreAction
{
    private $renderer;
    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }
    public function __invoke(Request $request)
    {
        $slug = $request->getAttribute('slug');
        if ($slug) {
            return $this->show($slug);
        } else {
            return $this->index();
        }
    }
    public function index(): string
    {
        return $this->renderer->render('@store/index');
    }
    public function show(string $slug): string
    {
        return $this->renderer->render('@store/show', [
            'slug' => $slug
        ]);
    }
}
