<?php

declare(strict_types=1);

namespace App\Adapter;

use Exception;
use RuntimeException;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

final class StripePaymentProcessorAdapter implements PaymentProcessorInterface
{
    public function __construct(
        private readonly StripePaymentProcessor $paymentProcessor,
    ) {
    }

    public function pay(float $price): bool
    {
        try {
            if (!$this->paymentProcessor->processPayment($price)) {
                throw new RuntimeException('Too low price');
            }

            return true;
        } catch (Exception $e) {
            throw new RuntimeException(
                'Payment error: ' . $e->getMessage()
            );
        }
    }
}
