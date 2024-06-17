<?php

declare(strict_types=1);

namespace App\Registry;

use App\Adapter\PaymentProcessorInterface;

final class PaymentProcessorRegistry
{
    public function __construct(
        private array $processorAdapters = [],
    ) {
    }

    public function register(string $key, PaymentProcessorInterface $processor): void
    {
        $this->processorAdapters[$key] = $processor;
    }

    public function resolve(string $key): PaymentProcessorInterface
    {
        return $this->processorAdapters[$key] ?? throw new \Exception('Payment processor not found!');
    }

}