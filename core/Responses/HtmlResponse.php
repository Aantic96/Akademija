<?php

namespace Core\Responses;

use Core\Interfaces\ResponseInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class HtmlResponse implements ResponseInterface
{
    protected string $view;
    protected array $content;

    public function __construct(string $view, array $content)
    {
        $this->view = $view;
        $this->content = $content;
    }

    public function send(): string
    {
        $loader = new FilesystemLoader('../app/Views');
        $twig = new Environment($loader, []);
        $template = $twig->load($this->view);
        return $template->render($this->content);
    }
}