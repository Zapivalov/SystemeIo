<?php

declare(strict_types=1);

namespace App\Transformer;

final class PriceTransformer
{
    public function transform(float $price): array
    {
        return [
            'price' => $price,
        ];
    }
}
