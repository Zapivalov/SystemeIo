<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\PriceRequestInterface;
use App\Enum\CouponDiscountType;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use App\Repository\TaxRepository;
use RuntimeException;
use Throwable;

final class PriceCalculator implements PriceCalculatorInterface
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly TaxRepository $taxRepository,
        private readonly CouponRepository $couponRepository,
    ) {
    }

    public function calculateFinalPrice(PriceRequestInterface $request): float
    {
        try {
            $basePrice = $this->productRepository->findPriceById($request->getProductId());
            $taxRatePercentage = $this->taxRepository->getByTaxNumber($request->getTaxNumber());
            $coupon = $request->getCouponCode()
                ? $this->couponRepository->getActiveCouponByName($request->getCouponCode())
                : null;

            $discount = 0;

            if ($coupon) {
                if ($coupon->getDiscountType() === CouponDiscountType::percentage->name) {
                    $discount = $basePrice * ($coupon->getValue() / 100);
                } elseif ($coupon->getDiscountType() === CouponDiscountType::fixed->name) {
                    $discount = $coupon->getValue();
                }
            }

            $priceAfterDiscount = $basePrice - $discount;
            $finalPrice = $priceAfterDiscount * (1 + $taxRatePercentage->getInterestRate() / 100);

            return round($finalPrice, 2);
        } catch (Throwable $e) {
            throw new RuntimeException('Error calculating final price: ' . $e->getMessage());
        }
    }
}
