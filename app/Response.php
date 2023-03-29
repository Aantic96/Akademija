<?php

namespace App;

use App\Interfaces\ResponseInterface;

class Response implements ResponseInterface
{
    public function send(string $content): string {
        return $content;
    }
}