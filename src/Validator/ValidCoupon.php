<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
final class ValidCoupon extends Constraint
{
    public string $message = 'The coupon "{{ value }}" is not valid.';
}
