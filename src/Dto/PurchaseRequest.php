<?php

declare(strict_types=1);

namespace App\Dto;

use App\Validator\ValidCoupon;
use App\Validator\ValidProduct;
use App\Validator\ValidTax;
use Symfony\Component\Validator\Constraints as Assert;

final class PurchaseRequest
{
    public function __construct(

        #[ValidProduct]
        private readonly ?int $product = null,

        #[ValidTax]
        private readonly ?string $taxNumber = null,

        #[ValidCoupon]
        private readonly ?string $couponCode = null,

        #[Assert\NotBlank(message: 'paymentProcessor field should not be blank')]
        private readonly ?string $paymentProcessor = null,
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

    public function getPaymentProcessor(): string
    {
        return $this->paymentProcessor;
    }
}
