<?php

namespace App\Services;


class ApiTokenService
{
    static public function generate(): string
    {
        return md5(uniqid().rand(1000000, 9999999));
    }
}
