<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

interface OrderRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): Order;

    public function create(array $data): Order;

    public function update(Order $order, array $data): Order;

    public function delete(Order $order): bool;
}
