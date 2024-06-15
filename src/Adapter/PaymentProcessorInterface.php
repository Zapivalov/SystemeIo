<?php

namespace App\Adapter;

interface PaymentProcessorInterface
{
    public function pay(float $price): bool;
}
