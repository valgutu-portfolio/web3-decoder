<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class NotFoundException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null, protected ?int $id = null)
    {
        parent::__construct($message, $code, $previous);
    }

    private function message(): string
    {
        return $this->id ? 'Not found: '.$this->id : 'Not found';
    }
}
