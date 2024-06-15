<?php

declare(strict_types=1);

namespace App\Adapter;

use Exception;
use RuntimeException;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;

final class PaypalPaymentProcessorAdapter implements PaymentProcessorInterface
{
    public function __construct(
        private readonly PaypalPaymentProcessor $paymentProcessor,
    ) {
    }

    public function pay(float $price): bool
    {
        try {
            $this->paymentProcessor->pay((int)$price * 100);

            return true;
        } catch (Exception $e) {
            throw new RuntimeException(
                'Payment error: ' . $e->getMessage()
            );
        }
    }
}
