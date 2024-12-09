<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        private CartService $cartService,
        private ProductService $productService
    ) {}

    public function index()
    {
        $cart = $this->cartService->getOrCreateCart(auth()->user());
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, int $productId)
    {
        $product = $this->productService->getProduct($productId);
        $quantity = $request->get('quantity', 1);

        $this->cartService->addToCart(auth()->user(), $product->getId(), $quantity);

        return redirect()->back()->with('success', 'Product added to cart');
    }

    public function update(Request $request, int $itemId)
    {
        $cart = $this->cartService->getOrCreateCart(auth()->user());
        $quantity = $request->get('quantity', 1);

        $this->cartService->updateQuantity($cart, $itemId, $quantity);

        return redirect()->back()->with('success', 'Cart updated');
    }

    public function remove(int $itemId)
    {
        $cart = $this->cartService->getOrCreateCart(auth()->user());
        $this->cartService->removeFromCart($cart, $itemId);

        return redirect()->back()->with('success', 'Item removed from cart');
    }

    public function applyCoupon(Request $request)
    {
        $cart = $this->cartService->getOrCreateCart(auth()->user());
        $couponCode = $request->get('code');

        $this->cartService->applyCoupon($cart, $couponCode);

        return redirect()->back()->with('success', 'Coupon applied');
    }
}
