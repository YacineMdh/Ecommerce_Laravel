<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService
    ) {}

    public function index()
    {
        $orders = $this->orderService->getUserOrders(auth()->user());
        return view('orders.index', compact('orders'));
    }

    public function show(int $id)
    {
        $order = $this->orderService->getOrder($id);
        return view('orders.show', compact('order'));
    }
}
