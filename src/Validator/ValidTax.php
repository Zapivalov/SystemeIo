<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
final class ValidTax extends Constraint
{
    public string $message = 'The taxNumber "{{ value }}" is not valid.';
    public string $notExistMessage = 'The taxNumber "{{ value }}" does not exist.';
    public string $emptyMessage = 'The value should not be empty.';
}
