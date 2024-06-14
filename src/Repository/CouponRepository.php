<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Coupon;
use App\Enum\CouponStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use RuntimeException;

class CouponRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coupon::class);
    }

    public function findActiveCouponByName(string $name): ?Coupon
    {
        return $this->createQueryBuilder('c')
            ->where('c.name = :name')
            ->andWhere('c.status = :status')
            ->setParameter('name', $name)
            ->setParameter('status', CouponStatus::active)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getActiveCouponByName(string $name): ?Coupon
    {
        $coupon = $this->findActiveCouponByName($name);

        if (!$coupon instanceof Coupon) {
            throw new RuntimeException('Coupon not found');
        }

        return $coupon;
    }
}
