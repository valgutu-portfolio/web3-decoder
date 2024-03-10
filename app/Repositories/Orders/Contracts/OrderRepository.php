<?php

namespace App\Repositories\Orders\Contracts;

use App\Repositories\Orders\DTO\CreateOrderRequest;
use App\Repositories\Orders\DTO\UpdateOrderRequest;
use App\Repositories\Shared\DTO\RepositoryResponse;

interface OrderRepository
{
    public function create(CreateOrderRequest $request): RepositoryResponse;

    public function update(UpdateOrderRequest $request): RepositoryResponse;

    public function findById(int $id): RepositoryResponse;

    public function findByPaymentSystemId(string $id): RepositoryResponse;
}
