<?php

namespace Core\Interfaces;

interface ResponseInterface
{
    public function send(): string;
}