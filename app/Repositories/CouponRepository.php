<?php

namespace App\Repositories;

use App\Entities\Coupon;
use Doctrine\ORM\EntityManagerInterface;

class CouponRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function findByCode(string $code): ?Coupon
    {
        return $this->entityManager
            ->getRepository(Coupon::class)
            ->findOneBy(['code' => $code, 'isActive' => true]);
    }

    public function save(Coupon $coupon): void
    {
        $this->entityManager->persist($coupon);
        $this->entityManager->flush();
    }

    public function delete(Coupon $coupon): void
    {
        $this->entityManager->remove($coupon);
        $this->entityManager->flush();
    }

    public function findAll()
    {
        return $this->entityManager
            ->getRepository(Coupon::class)
            ->findAll();
    }
}
