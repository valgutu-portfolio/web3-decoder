<?php

namespace App\Http\DTO;

use Illuminate\Http\JsonResponse;

class ErrorJsonResponse extends JsonResponse
{
    public function __construct(
        protected int $code,
        protected array $errors = [],
    )
    {
        $this->errors['success'] = false;
        $this->errors['code'] = $code;
        parent::__construct($this->errors, $this->code);
    }

    public function getStatusCode(): int
    {
        return $this->code;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
