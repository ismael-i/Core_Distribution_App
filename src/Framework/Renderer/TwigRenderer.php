<?php

namespace Framework\Renderer;

class TwigRenderer implements RendererInterface
{
    private $twig;
    private $loader;

    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig)
    {
        $this->loader = $loader;
        //new \Twig\Loader\FilesystemLoader($path);
        $this->twig = $twig;
        //new \Twig\Environment($this->loader, []);
    }

    /**
     * Add url , pour changer le views
     * @param string $namespace
     * @param null/string $path
     */

    public function addPath(string $namespace, ?string $path = null): void
    {
        $this->loader->addPath($path, $namespace);
    }

    /**
     * Permet de charget les views
     * Le chemin peut etre preciser ave des namespace via addpath
     * $this->render('@blog/view')
     * @param string $views
     * @param array $params
     * @return string
     */

    public function render(string $view, array $params = []): string
    {
        return $this->twig->render($view . '.html.twig', $params);
    }


    /**
     * Permet de rajouter de variables  a des views
     * @param string $key
     * @param mixed $value
     */
    public function addGlobal(string $key, $value): void
    {
        $this->twig->addGlobal($key, $value);
    }
}
