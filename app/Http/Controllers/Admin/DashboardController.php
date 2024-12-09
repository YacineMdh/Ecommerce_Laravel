<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\UserService;

class DashboardController extends Controller
{
    public function __construct(
        private OrderService $orderService,
        private ProductService $productService,
        private UserService $userService
    ) {}

    public function index()
    {
        $stats = [
            'totalOrders' => $this->orderService->getTotalOrders(),
            'totalProducts' => $this->productService->getTotalProducts(),
            'totalUsers' => $this->userService->getTotalUsers(),
            'recentOrders' => $this->orderService->getRecentOrders(),
            'topProducts' => $this->productService->getTopProducts()
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
