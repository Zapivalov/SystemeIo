<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\PurchaseRequest;
use App\Registry\PaymentProcessorRegistry;
use App\Service\PriceCalculatorInterface;
use App\Transformer\PaymentStatusTransformer;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

#[Route(
    '/purchase',
    name: 'api.purchase',
    methods: [Request::METHOD_POST],
)]
final class PurchaseAction extends AbstractController
{
    public function __construct(
        private readonly PriceCalculatorInterface $priceCalculator,
        private readonly PaymentProcessorRegistry $processorRegistry,
        private readonly PaymentStatusTransformer $statusTransformer,
    ) {
    }

    public function __invoke(
        #[MapRequestPayload] PurchaseRequest $purchaseRequest,
    ): JsonResponse
    {
        try {
            $price = $this->priceCalculator->calculateFinalPrice($purchaseRequest);
            $paymentProcessor = $this->processorRegistry->resolve($purchaseRequest->getPaymentProcessor());
            $paymentResult = $paymentProcessor->pay($price);


            return new JsonResponse($this->statusTransformer->transform($paymentResult));
        } catch (Throwable $e) {
            throw new RuntimeException(
                'An error occurred while executing the request: ' . $e->getMessage()
            );
        }
    }
}
