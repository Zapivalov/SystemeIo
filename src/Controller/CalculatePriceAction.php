<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\CalculatePriceRequest;
use App\Service\PriceCalculatorInterface;
use App\Transformer\PriceTransformer;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

#[Route(
    '/calculate-price',
    name: 'api.calculate-price',
    methods: [Request::METHOD_POST],
)]
final class CalculatePriceAction extends AbstractController
{
    public function __construct(
        private readonly PriceCalculatorInterface $priceCalculator,
        private readonly PriceTransformer $priceTransformer,
    ) {
    }

    public function __invoke(
        #[MapRequestPayload] CalculatePriceRequest $calculatePriceRequest,
    ): JsonResponse {
        try {
            $price = $this->priceCalculator->calculateFinalPrice($calculatePriceRequest);

            return new JsonResponse($this->priceTransformer->transform($price));
        } catch (Throwable $e) {
            throw new RuntimeException(
                'An error occurred while executing the request: ' . $e->getMessage()
            );
        }
    }
}
