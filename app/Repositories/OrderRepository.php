<?php

namespace App\Repositories;

use App\Entities\Order;
use App\Entities\User;
use Doctrine\ORM\EntityManagerInterface;

class OrderRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function findAll(): array
    {
        return $this->entityManager
            ->getRepository(Order::class)
            ->findAll();
    }

    public function findByUser(User $user): array
    {
        return $this->entityManager
            ->getRepository(Order::class)
            ->findBy(['user' => $user], ['createdAt' => 'DESC']);
    }

    public function find(int $id): ?Order
    {
        return $this->entityManager->find(Order::class, $id);
    }

    public function save(Order $order): void
    {
        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }

    public function updateStatus(Order $order, string $status): void
    {
        $order->setStatus($status);
        $this->entityManager->flush();
    }
    public function getTotalCount(): int
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('COUNT(o.id)')
            ->from(Order::class, 'o')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findRecent(int $limit): array
    {
        return $this->entityManager
            ->getRepository(Order::class)
            ->createQueryBuilder('o')
            ->orderBy('o.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
