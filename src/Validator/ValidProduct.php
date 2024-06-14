<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
final class ValidProduct extends Constraint
{
    public string $message = 'The product "{{ value }}" does not exist.';
    public string $emptyMessage = 'The value should not be empty.';
    public string $negativeMessage = 'The value must not be negative.';
}
