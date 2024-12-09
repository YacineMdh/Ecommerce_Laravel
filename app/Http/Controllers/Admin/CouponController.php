<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CouponService;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function __construct(
        private CouponService $couponService
    ) {}

    public function index()
    {
        $coupons = $this->couponService->getAllCoupons();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'discount' => 'required|numeric|min:0|max:100',
            'valid_until' => 'required|date|after:today',
            'is_active' => 'boolean'
        ]);

        $this->couponService->createCoupon($validatedData);
        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon créé avec succès');
    }

    public function edit(int $id)
    {
        $coupon = $this->couponService->getCoupon($id);
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, int $id)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|unique:coupons,code,' . $id,
            'discount' => 'required|numeric|min:0|max:100',
            'valid_until' => 'required|date',
            'is_active' => 'boolean'
        ]);

        $coupon = $this->couponService->getCoupon($id);
        $this->couponService->updateCoupon($coupon, $validatedData);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon mis à jour avec succès');
    }

    public function destroy(int $id)
    {
        $coupon = $this->couponService->getCoupon($id);
        $this->couponService->deleteCoupon($coupon);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon supprimé avec succès');
    }
}
