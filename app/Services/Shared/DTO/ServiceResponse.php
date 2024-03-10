<?php

namespace App\Services\Shared\DTO;

class ServiceResponse
{
    public function __construct(
        protected int $code,
        protected array $data = []
    )
    {
    }

    public function getStatusCode(): int
    {
        return $this->code;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function success(): bool
    {
        return (200 === $this->code);
    }
}
