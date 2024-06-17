<?php

declare(strict_types=1);

namespace App\Tests;

use App\Transformer\PriceTransformer;
use PHPUnit\Framework\TestCase;

final class PriceTransformerTest extends TestCase
{
    public function testTransform()
    {
        $priceTransformer = new PriceTransformer();

        $price = 100.0;
        $expectedResult = [
            'price' => $price,
        ];

        $result = $priceTransformer->transform($price);

        self::assertSame($expectedResult, $result);
    }
}
