<?php

declare(strict_types=1);

namespace App\Tests;

use App\Entity\Coupon;
use App\Entity\Tax;
use App\Enum\CouponDiscountType;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use App\Repository\TaxRepository;
use App\Service\PriceCalculator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;

final class PriceCalculatorTest extends TestCase
{
    private ProductRepository&Stub $productRepository;
    private TaxRepository&Stub $taxRepository;
    private CouponRepository&Stub $couponRepository;
    private PriceCalculator $priceCalculator;

    protected function setUp(): void
    {
        $this->productRepository = $this->createStub(ProductRepository::class);
        $this->taxRepository = $this->createStub(TaxRepository::class);
        $this->couponRepository = $this->createStub(CouponRepository::class);

        $this->priceCalculator = new PriceCalculator(
            $this->productRepository,
            $this->taxRepository,
            $this->couponRepository,
        );
    }

    public function testCalculatesWithoutCoupon(): void
    {
        $this->productRepository
            ->method('findPriceById')
            ->willReturn(13.99);
        $this->taxRepository
            ->method('getByTaxNumber')
            ->willReturn(new Tax('Germany', 13.0, 'DEXXXXXXXXX'));
        $this->couponRepository
            ->method('getActiveCouponByName')
            ->willReturn(null);

        $result = $this->priceCalculator->calculateFinalPrice(1, '123', '123');

        self::assertSame(15.81, $result);
    }

    #[DataProvider('provideCouponType')]
    public function testCalculatesWithCoupon(Coupon $coupon, float $expectedResult): void
    {
        $this->productRepository
            ->method('findPriceById')
            ->willReturn(13.99);
        $this->taxRepository
            ->method('getByTaxNumber')
            ->willReturn(new Tax('Germany', 13.0, 'DEXXXXXXXXX'));
        $this->couponRepository
            ->method('getActiveCouponByName')
            ->willReturn($coupon);

        $result = $this->priceCalculator->calculateFinalPrice(1, '123', '123');

        self::assertSame($expectedResult, $result);
    }

    public static function provideCouponType(): iterable
    {
        yield 'Percentage coupon with 13 percent' => [
            new Coupon('P', 13,CouponDiscountType::percentage),
            13.75,
        ];

        yield 'Fixed coupon with 2' => [
            new Coupon('F', 2,CouponDiscountType::fixed),
            13.55,
        ];
    }
}