<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Coupon;
use App\Enum\CouponDiscountType;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use App\Repository\TaxRepository;
use RuntimeException;
use Throwable;

final class PriceCalculator
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly TaxRepository $taxRepository,
        private readonly CouponRepository $couponRepository,
    ) {
    }

    public function calculateFinalPrice(int $productId, string $taxNumber, ?string $couponCode): float
    {
        try {
            $basePrice = $this->productRepository->findPriceById($productId);
            $taxRatePercentage = $this->taxRepository->getByTaxNumber($taxNumber);
            $coupon = $couponCode
                ? $this->couponRepository->getActiveCouponByName($couponCode)
                : null;

            $discount = $this->getDiscountAmount($coupon, $basePrice);
            $priceAfterDiscount = $basePrice - $discount;
            $finalPrice = $priceAfterDiscount * (1 + $taxRatePercentage->getInterestRate() / 100);

            return round($finalPrice, 2);
        } catch (Throwable $e) {
            throw new RuntimeException('Error calculating final price: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    private function getDiscountAmount(?Coupon $coupon, float $basePrice): float
    {
        if ($coupon === null) {
            return 0.0;
        }

        if ($coupon->getDiscountType() === CouponDiscountType::percentage->name) {
            return $basePrice * ($coupon->getValue() / 100);
        }

        if ($coupon->getDiscountType() === CouponDiscountType::fixed->name) {
            return $coupon->getValue();
        }

        return 0.0;
    }
}
