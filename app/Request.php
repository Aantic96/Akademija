<?php

namespace App;

use App\Interfaces\RequestInterface;

class Request implements RequestInterface
{
    protected array $params;
    protected array $body;
    protected string $method;
    protected string $uri;

    public function __construct()
    {
        $this->uri = parse_url($_SERVER['REQUEST_URI'])['path'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->setParams();
        $this->setBody();
    }

    protected function setParams(): void
    {
        $this->params = $_GET;
    }

    private function setBody()
    {
        $this->body = $_POST;
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

    public function addParams(array $params): void
    {
        $this->params = array_merge($this->params, $params);
    }
}