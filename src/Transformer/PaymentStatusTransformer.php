<?php

declare(strict_types=1);

namespace App\Transformer;


final class PaymentStatusTransformer
{
    public function transform(bool $status): array
    {
        return [
            'status' => $status ? 'success' : 'fail',
        ];
    }
}
