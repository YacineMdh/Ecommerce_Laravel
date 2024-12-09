<?php

namespace App\Repositories;

use App\Entities\CartItem;
use Doctrine\ORM\EntityManagerInterface;

class CartItemRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function find(int $id): ?CartItem
    {
        return $this->entityManager->find(CartItem::class, $id);
    }

    public function save(CartItem $cartItem): void
    {
        $this->entityManager->persist($cartItem);
        $this->entityManager->flush();
    }

    public function delete(CartItem $cartItem): void
    {
        $this->entityManager->remove($cartItem);
        $this->entityManager->flush();
    }
}
