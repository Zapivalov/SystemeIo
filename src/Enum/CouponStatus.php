<?php

declare(strict_types=1);

namespace App\Enum;

enum CouponStatus: int
{
    case active = 1;
    case inactive = 0;
}