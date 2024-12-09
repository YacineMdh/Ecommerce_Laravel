<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(
        private CartService $cartService,
        private OrderService $orderService
    ) {}

    public function index()
    {
        $cart = $this->cartService->getOrCreateCart(auth()->user());

        if ($this->cartService->isCartEmpty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Votre panier est vide');
        }

        return view('checkout.index', compact('cart'));
    }

    public function process(Request $request)
    {
        $validatedData = $request->validate([
            'shipping_address' => 'required|string',
            'billing_address' => 'required|string',
            'payment_method' => 'required|in:card,paypal'
        ]);

        try {
            $cart = $this->cartService->getOrCreateCart(auth()->user());

            // Vérifier si le panier n'est pas vide
            if ($this->cartService->isCartEmpty($cart)) {
                return redirect()->route('cart.index')
                    ->with('error', 'Votre panier est vide');
            }

            // Vérifier les stocks
            if (!$this->cartService->validateStock($cart)) {
                return redirect()->route('cart.index')
                    ->with('error', 'Certains produits ne sont plus en stock');
            }

            // Créer la commande
            $order = $this->orderService->createFromCart($cart, $validatedData);

            // Vider le panier
            $this->cartService->clearCart($cart);

            return redirect()->route('checkout.success', ['order' => $order->getId()])
                ->with('success', 'Votre commande a été traitée avec succès');

        } catch (\Exception $e) {
            return redirect()->route('checkout.index')
                ->with('error', 'Une erreur est survenue lors du traitement de votre commande');
        }
    }

    public function success(int $orderId)
    {
        $order = $this->orderService->getOrder($orderId);

        if (!$order || $order->getUser()->getId() !== auth()->id()) {
            abort(404);
        }

        return view('checkout.success', compact('order'));
    }
}
