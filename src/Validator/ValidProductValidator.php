<?php

declare(strict_types=1);

namespace App\Validator;

use App\Repository\ProductRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class ValidProductValidator extends ConstraintValidator
{
    public function __construct(
        private readonly ProductRepository $productRepository
    ) {
    }

    public function validate($value, Constraint $constraint): void
    {
        if (null === $value || '' === $value) {
            $this->context->buildViolation($constraint->emptyMessage)
                ->addViolation();
            return;
        }

        if ($value < 0) {
            $this->context->buildViolation($constraint->negativeMessage)
                ->addViolation();
            return;
        }

        if (!$this->productRepository->find($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', (string) $value)
                ->addViolation();
        }
    }
}
