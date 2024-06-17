<?php

declare(strict_types=1);

namespace App\Tests;

use App\Transformer\PaymentStatusTransformer;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class PaymentStatusTransformerTest extends TestCase
{
    #[DataProvider('provideDataTransformer')]
    public function testTransform(bool $status, array $expectedResult)
    {
        $transformer = new PaymentStatusTransformer();

        $result = $transformer->transform($status);

        self::assertSame($expectedResult, $result);
    }

    public static function provideDataTransformer(): iterable
    {
        yield [
            true,
            ['status' => 'success'],
        ];

        yield [
            false,
            ['status' => 'fail'],
        ];
    }
}
