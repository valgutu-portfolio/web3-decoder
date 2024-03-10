<?php

namespace App\Http\DTO;

use Illuminate\Http\JsonResponse;

class SuccessJsonResponse extends JsonResponse
{
    public function __construct(
        protected int $code = 200,
        protected array $data = [],
    )
    {
        parent::__construct($this->data, $this->code);
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
