<?php

namespace App\Interfaces;

interface RequestInterface
{
    public function getMethod(): string;

    public function getParams(): string;

    public function getUri(): string;
}