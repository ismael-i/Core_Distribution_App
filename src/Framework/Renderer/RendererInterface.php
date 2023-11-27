<?php

namespace Framework\Renderer;

interface RendererInterface
{
    /**
     * Add url , pour changer le views
     * @param string $namespace
     * @param null/string $path
     */

    public function addPath(string $namespace, ?string $path = null): void;

    /**
     * Permet de charget les views
     * Le chemin peut etre preciser ave des namespace via addpath
     * $this->render('@blog/view')
     * @param string $views
     * @param array $params
     * @return string
     */

    public function render(string $view, array $params = []): string;


    /**
     * Permet de rajouter de variables  a des views
     * @param string $key
     * @param mixed $value
     */
    public function addGlobal(string $key, $value): void;
}
