<?php

namespace App\Repositories;

use App\Entities\Cart;
use App\Entities\CartItem;
use App\Entities\Product;
use App\Entities\User;
use Doctrine\ORM\EntityManagerInterface;

class CartRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function findByUser(User $user): ?Cart
    {
        return $this->entityManager
            ->getRepository(Cart::class)
            ->findOneBy(['user' => $user]);
    }

    public function addItem(Cart $cart, Product $product, int $quantity): void
    {
        // Vérifier si le produit existe déjà dans le panier
        $existingItem = $this->findCartItem($cart, $product);

        if ($existingItem) {
            // Si oui, mettre à jour la quantité
            $existingItem->setQuantity($existingItem->getQuantity() + $quantity);
        } else {
            // Si non, créer un nouveau CartItem
            $cartItem = new CartItem();
            $cartItem->setCart($cart);
            $cartItem->setProduct($product);
            $cartItem->setQuantity($quantity);
            $cartItem->setPrice((string)$product->getPrice());

            $this->entityManager->persist($cartItem);
        }

        // Recalculer le total du panier
        $this->updateCartTotal($cart);

        $this->entityManager->flush();
    }

    public function updateItemQuantity(CartItem $cartItem, int $quantity): void
    {
        $cartItem->setQuantity($quantity);
        $this->updateCartTotal($cartItem->getCart());
        $this->entityManager->flush();
    }

    public function removeItem(CartItem $cartItem): void
    {
        $cart = $cartItem->getCart();
        $this->entityManager->remove($cartItem);
        $this->updateCartTotal($cart);
        $this->entityManager->flush();
    }

    public function save(Cart $cart): void
    {
        $this->entityManager->persist($cart);
        $this->entityManager->flush();
    }

    public function clear(Cart $cart): void
    {
        foreach ($cart->getItems() as $item) {
            $this->entityManager->remove($item);
        }
        $cart->setTotal('0.00');
        $this->entityManager->flush();
    }

    private function findCartItem(Cart $cart, Product $product): ?CartItem
    {
        return $this->entityManager
            ->getRepository(CartItem::class)
            ->findOneBy([
                'cart' => $cart,
                'product' => $product
            ]);
    }

    private function updateCartTotal(Cart $cart): void
    {
        $total = '0.00';
        foreach ($cart->getItems() as $item) {
            $itemTotal = bcmul($item->getPrice(), (string)$item->getQuantity(), 2);
            $total = bcadd($total, $itemTotal, 2);
        }
        $cart->setTotal($total);
    }

    public function createCart(User $user): Cart
    {
        $cart = new Cart();
        $cart->setUser($user);
        $cart->setTotal('0.00');
        $this->entityManager->persist($cart);
        $this->entityManager->flush();

        return $cart;
    }

    public function getCartTotal(Cart $cart): string
    {
        return $cart->getTotal();
    }

    public function getCartItemCount(Cart $cart): int
    {
        return count($cart->getItems());
    }

    public function getCartItems(Cart $cart): array
    {
        return $cart->getItems()->toArray();
    }

    public function isCartEmpty(Cart $cart): bool
    {
        return $cart->getItems()->isEmpty();
    }

    public function find(int $id): ?Cart
    {
        return $this->entityManager->find(Cart::class, $id);
    }

    public function delete(Cart $cart): void
    {
        $this->entityManager->remove($cart);
        $this->entityManager->flush();
    }
}
