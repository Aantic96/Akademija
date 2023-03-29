<?php

namespace App\Interfaces;

interface RequestInterface
{
    public function checkMethod(string $superGlobalMethodType);
}