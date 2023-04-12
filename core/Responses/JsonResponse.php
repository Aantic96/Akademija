<?php

namespace Core\Responses;

use Core\Interfaces\ResponseInterface;

class JsonResponse implements ResponseInterface
{
    protected string $content;

    public function __construct(array $content)
    {
        $this->content = json_encode($content);
    }

    public function send(): string
    {
        $this->setJsonContentType();
        return $this->content;
    }

    //For browser to know that JSON is returned
    protected function setJsonContentType(): void
    {
        header("Content-Type: application/json");
    }
}