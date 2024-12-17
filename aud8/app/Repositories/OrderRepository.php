<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository implements OrderRepositoryInterface
{
    public function all(): Collection
    {
        return Order::all();
    }

    public function find(int $id): Order
    {
        return Order::query()
            ->findOrFail($id);
    }

    public function create(array $data): Order
    {
        return Order::query()
            ->create($data);
    }

    public function update(Order $order, array $data): Order
    {
        $order->update($data);

        return $order;
    }

    public function delete(Order $order): bool
    {
        return $order->delete();
    }
}
