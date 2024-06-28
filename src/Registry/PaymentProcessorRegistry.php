<?php

declare(strict_types=1);

namespace App\Registry;

use App\Adapter\PaymentProcessorInterface;
use Psr\Container\ContainerInterface;

final class PaymentProcessorRegistry
{
    public function __construct(
        private readonly ContainerInterface $locator,
    ) {
    }

    public function resolve(string $key): PaymentProcessorInterface
    {
        return $this->locator->has($key)
            ? $this->locator->get($key)
            : throw new \Exception('Payment processor not found!');
    }
}
