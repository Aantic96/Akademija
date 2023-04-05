<?php

namespace App\Controllers;

use App\Interfaces\RequestInterface;

abstract class BaseController
{
    protected RequestInterface $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }
}