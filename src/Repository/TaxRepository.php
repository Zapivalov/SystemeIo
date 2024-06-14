<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Tax;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use RuntimeException;

class TaxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tax::class);
    }

    public function findFormatByTaxNumber(string $taxNumber): ?string
    {
        $countryCode = substr($taxNumber, 0, 2);

        return $this->createQueryBuilder('t')
            ->select('t.format')
            ->where('t.format LIKE :domain')
            ->setParameter('domain', $countryCode . '%')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getByTaxNumber(string $taxNumber): ?Tax
    {
        $tax = $this->findByTaxNumber($taxNumber);

        if (!$tax instanceof Tax) {
            throw new RuntimeException('Tax not found');
        }

        return $tax;
    }

    private function findByTaxNumber(string $taxNumber): ?Tax
    {
        $countryCode = substr($taxNumber, 0, 2);

        return $this->createQueryBuilder('t')
            ->where('t.format LIKE :domain')
            ->setParameter('domain', $countryCode . '%')
            ->getQuery()
            ->getOneOrNullResult();
    }
}
