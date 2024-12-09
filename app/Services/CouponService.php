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

    public function validateCoupon(string $code): ?Coupon
    {
        $coupon = $this->couponRepository->findByCode($code);

        if (!$coupon || $coupon->getValidUntil() < new \DateTime()) {
            return null;
        }

        return $coupon;
    }

    public function applyDiscount(string $total, Coupon $coupon): string
    {
        $discount = bcmul($total, bcdiv($coupon->getDiscount(), '100', 2), 2);
        return bcsub($total, $discount, 2);
    }
}
