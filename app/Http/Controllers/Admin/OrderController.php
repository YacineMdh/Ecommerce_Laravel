<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService
    ) {}

    public function index()
    {
        $orders = $this->orderService->getAllOrders();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(int $id)
    {
        $order = $this->orderService->getOrder($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, int $id)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order = $this->orderService->getOrder($id);
        $this->orderService->updateOrderStatus($order, $validatedData['status']);

        return redirect()->back()->with('success', 'Order status updated');
    }
}
