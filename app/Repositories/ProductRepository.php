<?php

namespace App\Repositories;

use App\Entities\Product;
use Doctrine\ORM\EntityManagerInterface;

class ProductRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function findAll(): array
    {
        return $this->entityManager
            ->getRepository(Product::class)
            ->findAll();
    }

    public function find(int $id): ?Product
    {
        return $this->entityManager->find(Product::class, $id);
    }

    public function save(Product $product): void
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }

    public function delete(Product $product): void
    {
        $this->entityManager->remove($product);
        $this->entityManager->flush();
    }
    public function findFeaturedProducts(int $limit): array
    {
        return $this->entityManager
            ->getRepository(Product::class)
            ->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')  // Ou tout autre critère de tri
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
    public function getTotalCount(): int
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('COUNT(p.id)')
            ->from(Product::class, 'p')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findTopProducts(int $limit): array
    {
        return $this->entityManager
            ->getRepository(Product::class)
            ->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')  // Ou un autre critère de tri
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
