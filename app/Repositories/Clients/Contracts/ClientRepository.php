<?php

namespace App\Repositories\Clients\Contracts;

use App\Repositories\Shared\DTO\RepositoryResponse;

interface ClientRepository
{
    public function findByToken(?string $token): RepositoryResponse;
}
