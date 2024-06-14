<?php

declare(strict_types=1);

namespace App\Validator;

use App\Repository\CouponRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class ValidCouponValidator extends ConstraintValidator
{
    public function __construct(
        private readonly CouponRepository $couponRepository
    ) {
    }

    public function validate($value, Constraint $constraint): void
    {
        if (null === $value || '' === $value) {
            return;
        }

        if (!$this->couponRepository->findActiveCouponByName($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
