<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Repositories\OrderRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller
{
    protected OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function index(): AnonymousResourceCollection
    {
        $orders = $this->orderRepository->all();

        return OrderResource::collection($orders);
    }

    public function store(Request $request): OrderResource
    {
        $data = $request->all();
        $order = $this->orderRepository->create($data);

        return OrderResource::make($order);
    }

    public function show(string $id): OrderResource
    {
        $order = $this->orderRepository->find($id);

        return OrderResource::make($order);
    }

    public function update(Request $request, string $id): OrderResource
    {
        $data = $request->all();
        $order = $this->orderRepository->find($id);
        $order = $this->orderRepository->update($order, $data);

        return OrderResource::make($order);
    }

    public function destroy($id): JsonResponse
    {
        $order = $this->orderRepository->find($id);
        $this->orderRepository->delete($order);

        return response()->json(null, 204);
    }
}
