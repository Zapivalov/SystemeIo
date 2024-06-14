<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;
use RuntimeException;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findPriceById(int $id): ?float
    {
        try {
            return $this->createQueryBuilder('p')
                ->select('p.price')
                ->where('p.id = :id')
                ->setParameter('id',  $id)
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NoResultException) {
            throw new RuntimeException('Product ' . $id . ' not found');
        }
    }
}
