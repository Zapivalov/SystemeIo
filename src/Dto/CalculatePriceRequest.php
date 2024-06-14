<?php

declare(strict_types=1);

namespace App\Dto;

use App\Validator\ValidCoupon;
use App\Validator\ValidProduct;
use App\Validator\ValidTax;

final class CalculatePriceRequest implements PriceRequestInterface
{
    public function __construct(

        #[ValidProduct]
        private readonly ?int $product = null,

        #[ValidTax]
        private readonly ?string $taxNumber = null,

        #[ValidCoupon]
        private readonly ?string $couponCode = null,
    ) {
    }

    public function getProductId(): int
    {
        return $this->product;
    }

    public function getTaxNumber(): string
    {
        return $this->taxNumber;
    }

    public function getCouponCode(): ?string
    {
        return $this->couponCode;
    }
}
