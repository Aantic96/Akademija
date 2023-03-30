<?php

namespace App;

use App\Interfaces\RequestInterface;

class Request implements RequestInterface
{
    protected array $params;
    protected string $method;
    protected string $uri;

    public function __construct()
    {
        $this->uri = parse_url($_SERVER['REQUEST_URI'])['path'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->setParams();
    }

    protected function setParams(): void
    {
        if ($this->method == "GET") {
            $this->params[] = $_GET;
        } else if ($this->method == "POST") {
            $this->params[] = $_POST;
        } else {
            throw new \Exception("Method $this->method not supported");
        }
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getUri(): string
    {
        return $this->uri;
    }
}