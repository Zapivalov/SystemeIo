<?php

namespace App\Service;

use App\Dto\PriceRequestInterface;

interface PriceCalculatorInterface
{
    public function calculateFinalPrice(PriceRequestInterface $request): float;
}