<?php

namespace App\Services;

use App\Entities\Cart;
use App\Entities\Product;
use App\Entities\User;
use App\Entities\CartItem;
use App\Repositories\CartRepository;
use App\Repositories\CouponRepository;
use App\Repositories\ProductRepository;

class CartService
{

    public function __construct(
        private CartRepository $cartRepository,
        private ProductRepository $productRepository,
        private CouponRepository $couponRepository,
        private CouponService $couponService
    ) {}

    public function getOrCreateCart(User $user): Cart
    {
        $cart = $this->cartRepository->findByUser($user);

        if (!$cart) {
            $cart = $this->cartRepository->createCart($user);
        }

        return $cart;
    }

    public function addToCart(User $user, int $productId, int $quantity): void
    {
        $cart = $this->getOrCreateCart($user);
        $product = $this->productRepository->find($productId);

        if (!$product) {
            throw new \Exception('Product not found');
        }

        $this->cartRepository->addItem($cart, $product, $quantity);
    }

    public function updateQuantity(Cart $cart, int $itemId, int $quantity): void
    {
        if ($quantity <= 0) {
            $this->removeFromCart($cart, $itemId);
            return;
        }

        $this->cartRepository->updateItemQuantity($cart, $itemId, $quantity);
    }

    public function removeFromCart(Cart $cart, int $itemId): void
    {
        $cartItem = $cart->getItems()->filter(
            fn($item) => $item->getId() === $itemId
        )->first();

        if ($cartItem) {
            $this->cartRepository->removeItem($cartItem);
        }
    }

    public function clearCart(Cart $cart): void
    {
        $this->cartRepository->clear($cart);
    }

    public function getCartTotal(Cart $cart): string
    {
        return $this->cartRepository->getCartTotal($cart);
    }

    public function getCartItemCount(Cart $cart): int
    {
        return $this->cartRepository->getCartItemCount($cart);
    }

    public function isCartEmpty(Cart $cart): bool
    {
        return $this->cartRepository->isCartEmpty($cart);
    }

    public function applyCoupon(Cart $cart, string $couponCode): bool
    {
        $coupon = $this->couponRepository->findByCode($couponCode);

        if (!$coupon) {
            return false;
        }

        // apply discount
        $total = $this->cartRepository->getCartTotal($cart);
        $discountedTotal = $this->couponService->applyDiscount($total, $coupon);

        $cart->setTotal($discountedTotal);

        $this->cartRepository->save($cart);
        return true;
    }

    public function validateStock(Cart $cart): bool
    {
        foreach ($cart->getItems() as $item) {
            if ($item->getQuantity() > $item->getProduct()->getStock()) {
                return false;
            }
        }
        return true;
    }

    public function calculateTotal(Cart $cart)
    {
        $total = 0;

        foreach ($cart->getItems() as $item) {
            $total += $item->getProduct()->getPrice() * $item->getQuantity();
        }

        return $total;
    }
}
