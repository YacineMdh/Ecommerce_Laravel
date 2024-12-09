<?php

namespace App\Repositories;

use App\Entities\Category;
use Doctrine\ORM\EntityManagerInterface;

class CategoryRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function findAll(): array
    {
        return $this->entityManager
            ->getRepository(Category::class)
            ->findAll();
    }

    public function find(int $id): ?Category
    {
        return $this->entityManager->find(Category::class, $id);
    }

    public function save(Category $category): void
    {
        $this->entityManager->persist($category);
        $this->entityManager->flush();
    }

    public function delete(Category $category): void
    {
        $this->entityManager->remove($category);
        $this->entityManager->flush();
    }
}
