<?php

namespace App\Services;

use App\Entities\Order;
use App\Entities\Cart;
use App\Entities\OrderItem;
use App\Entities\User;
use App\Repositories\OrderRepository;
use App\Services\CartService;

class OrderService
{
    public function __construct(
        private OrderRepository $orderRepository,
        private CartService $cartService
    ) {}

    public function createFromCart(Cart $cart, array $data): Order
    {
        $order = new Order();
        $order->setUser($cart->getUser());
        $order->setTotal($this->cartService->calculateTotal($cart));

        foreach ($cart->getItems() as $cartItem) {
            $orderItem = new OrderItem();
            $orderItem->setProduct($cartItem->getProduct());
            $orderItem->setQuantity($cartItem->getQuantity());
            $orderItem->setPrice($cartItem->getPrice());
            $order->addItem($orderItem);
        }

        $this->orderRepository->save($order);
        return $order;
    }

    public function getUserOrders(User $user): array
    {
        return $this->orderRepository->findByUser($user);
    }

    public function updateOrderStatus(Order $order, string $status): void
    {
        $this->orderRepository->updateStatus($order, $status);
    }

    public function getTotalOrders(): int
    {
        return $this->orderRepository->getTotalCount();
    }

    public function getRecentOrders(int $limit = 5): array
    {
        return $this->orderRepository->findRecent($limit);
    }

    public function getAllOrders()
    {
        return $this->orderRepository->findAll();
    }

    public function getOrder(int $id)
    {
        return $this->orderRepository->find($id);
    }
}
