<?php

namespace App\Dto;

interface PriceRequestInterface
{
    public function getProductId(): int;
    public function getTaxNumber(): string;
    public function getCouponCode(): ?string;
}