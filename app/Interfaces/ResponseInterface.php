<?php

namespace App\Interfaces;

interface ResponseInterface
{
    public function send(string $content): string;
}