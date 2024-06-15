<?php

declare(strict_types=1);

namespace App\Registry;

use App\Adapter\PaymentProcessorInterface;

final class PaymentProcessorRegistry
{
    private array $processorAdapters;

    public function register(string $key, PaymentProcessorInterface $processor): void
    {
        $this->processorAdapterss[$key] = $processor;
    }

    public function resolve(string $key): PaymentProcessorInterface
    {
        return $this->processorAdapterss[$key] ?? throw new \Exception('Payment processor not found!');
    }

}