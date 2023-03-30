<?php

namespace App;

use App\Interfaces\RequestInterface;

class Request implements RequestInterface
{
    protected array $params;
    protected string $method;

    public function __construct(array $params)
    {
        $this->params = $params;
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public function getMethod(): string {
        return $this->method;
    }


}