<?php

namespace App;

use App\Interfaces\RequestInterface;

class Request implements RequestInterface
{
    protected array $params;
    protected array $body;
    protected array $attributes;
    protected string $method;
    protected string $uri;

    public function __construct()
    {
        $this->uri = parse_url($_SERVER['REQUEST_URI'])['path'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->setParams();
        $this->setBody();
        $this->attributes = [];
    }

    protected function setParams(): void
    {
        $this->params = $_GET;
    }

    private function setBody(): void
    {
        $this->body = $_POST;
    }

    public function setAttributes(array $placeholderParams): void
    {
        $this->attributes = $placeholderParams;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }
}