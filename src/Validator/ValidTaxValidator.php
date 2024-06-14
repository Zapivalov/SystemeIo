<?php

declare(strict_types=1);

namespace App\Validator;

use App\Repository\TaxRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class ValidTaxValidator extends ConstraintValidator
{
    public function __construct(
        private readonly TaxRepository $taxRepository
    ) {
    }

    public function validate($value, Constraint $constraint): void
    {
        if (null === $value || '' === $value) {
            $this->context->buildViolation($constraint->emptyMessage)
                ->addViolation();
            return;
        }

        $format = $this->taxRepository->findFormatByTaxNumber($value);

        if (!$format) {
            $this->context->buildViolation($constraint->notExistMessage)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }

        $pattern = $this->convertFormatToRegex($format);

        if (!preg_match($pattern, $value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }

    private function convertFormatToRegex(string $format): string
    {
        $regex = str_replace(
            ['X', 'Y'],
            ['\d', '[A-Z]'],
            $format
        );

        return "/^{$regex}$/";
    }
}
