<?php

namespace Core\Responses;

use Core\Interfaces\ResponseInterface;

class Response implements ResponseInterface
{
    protected string $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function send(): string
    {
        return $this->content;
    }
}