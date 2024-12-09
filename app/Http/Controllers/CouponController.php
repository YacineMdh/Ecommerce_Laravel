<?php

namespace App\Services;

use App\Entities\Coupon;
use App\Repositories\CouponRepository;

class CouponService
{
    public function __construct(
        private CouponRepository $couponRepository
    ) {}

    public function getAllCoupons(): array
    {
        return $this->couponRepository->findAll();
    }

    public function getCoupon(int $id): ?Coupon
    {
        return $this->couponRepository->find($id);
    }

    public function createCoupon(array $data): Coupon
    {
        $coupon = new Coupon();
        $coupon->setCode($data['code']);
        $coupon->setDiscount($data['discount']);
        $coupon->setValidUntil(new \DateTime($data['valid_until']));
        $coupon->setIsActive($data['is_active'] ?? true);

        $this->couponRepository->save($coupon);

        return $coupon;
    }

    public function updateCoupon(Coupon $coupon, array $data): Coupon
    {
        $coupon->setCode($data['code']);
        $coupon->setDiscount($data['discount']);
        $coupon->setValidUntil(new \DateTime($data['valid_until']));
        $coupon->setIsActive($data['is_active'] ?? $coupon->isActive());

        $this->couponRepository->save($coupon);

        return $coupon;
    }

    public function deleteCoupon(Coupon $coupon): void
    {
        $this->couponRepository->delete($coupon);
    }

    public function validateCoupon(string $code): Coupon
    {
        $coupon = $this->couponRepository->findByCode($code);

        if (!$coupon) {
            throw new \Exception('Code promo invalide');
        }

        if (!$coupon->isActive()) {
            throw new \Exception('Ce code promo n\'est plus actif');
        }

        if ($coupon->getValidUntil() < new \DateTime()) {
            throw new \Exception('Ce code promo a expiré');
        }

        return $coupon;
    }

    public function calculateDiscount(float $amount, Coupon $coupon): float
    {
        return $amount * ($coupon->getDiscount() / 100);
    }
}
