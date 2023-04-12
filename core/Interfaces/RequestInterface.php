<?php

namespace Core\Interfaces;

interface RequestInterface
{
    public function getMethod(): string;

    public function getParams(): array;

    public function getBody(): array;

    public function getAttributes(): array;

    public function getUri(): string;

    public function setAttributes(array $placeholderParams): void;
}