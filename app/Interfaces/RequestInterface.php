<?php

namespace App\Interfaces;

interface RequestInterface
{
    public function getMethod(): string;

    public function getParams(): array;

    public function getUri(): string;
}