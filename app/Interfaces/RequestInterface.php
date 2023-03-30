<?php

namespace App\Interfaces;

interface RequestInterface
{
    public function getMethod(): string;
}