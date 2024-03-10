<?php

namespace App\Repositories\Orders;

use App\Repositories\Orders\Contracts\OrderRepository;
use App\Repositories\Orders\DTO\CreateOrderRequest;
use App\Repositories\Orders\DTO\UpdateOrderRequest;
use App\Repositories\Orders\Models\Order;
use App\Repositories\Shared\DTO\RepositoryResponse;

class EloquentOrderRepository implements OrderRepository
{
    public function create(CreateOrderRequest $request): RepositoryResponse
    {
        try {
            $model = Order::create($request->toArray());

            return new RepositoryResponse(200, $model->toArray());
        } catch (\Exception $e) {
            return new RepositoryResponse(500, ['message' => $e->getMessage()]);
        }
    }

    public function update(UpdateOrderRequest $request): RepositoryResponse
    {
        $model = Order::find($request->id());

        if (empty($model)) {
            throw new \Exception(sprintf("Order %s doesn't exist.", $request->id()));
        }

        if ($request->paymentSystemOrderId() !== null) {
            $model->payment_system_order_id = $request->paymentSystemOrderId();
        }

        if ($request->status() !== null) {
            $model->status = $request->status();
        }

        $model->save();

        return new RepositoryResponse(200, $model->toArray());
    }

    public function findById(int $id): RepositoryResponse
    {
        $model = Order::find($id);

        if (empty($model)) {
            throw new \Exception(sprintf("Order %s doesn't exist.", $id));
        }

        return new RepositoryResponse(200, $model->toArray());
    }

    public function findByPaymentSystemId(?string $id): RepositoryResponse
    {
        $model = Order::where('payment_system_order_id', $id)->first();

        if (empty($model)) {
            throw new \Exception(sprintf("Order %s doesn't exist.", $id));
        }

        return new RepositoryResponse(200, $model->toArray());
    }
}
