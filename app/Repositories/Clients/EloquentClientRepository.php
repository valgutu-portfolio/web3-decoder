<?php

namespace App\Repositories\Clients;

use App\Repositories\Clients\Contracts\ClientRepository;
use App\Repositories\Clients\Models\Client;
use App\Repositories\Shared\DTO\RepositoryResponse;

class EloquentClientRepository implements ClientRepository
{
    public function findByToken(?string $token): RepositoryResponse
    {
        $client = Client::where('token', $token)->first();

        if (empty($client)) {
            return new RepositoryResponse(400, []);
        }

        return new RepositoryResponse(200, [
            'client' => $client->toArray()
        ]);
    }
}
