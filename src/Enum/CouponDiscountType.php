<?php

declare(strict_types=1);

namespace App\Enum;

enum CouponDiscountType: int
{
    case percentage = 1;
    case fixed = 0;
}