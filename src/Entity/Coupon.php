<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\CouponDiscountType;
use App\Enum\CouponStatus;
use App\Repository\CouponRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouponRepository::class)]
class Coupon
{
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private int $id;

    #[ORM\Column(name: 'name', type: 'string', nullable: false)]
    private string $name;

    #[ORM\Column(name: 'value', type: 'float', nullable: false)]
    private float $value;

    #[ORM\Column(name: 'discount_type', nullable: false, enumType: CouponDiscountType::class)]
    private CouponDiscountType $discountType;

    #[ORM\Column(name: 'status', nullable: false, enumType: CouponStatus::class)]
    private CouponStatus $status;

    public function __construct(
        string $name,
        float $value,
        CouponDiscountType $discountType,
        CouponStatus $status = CouponStatus::active
    ) {
        $this->name = $name;
        $this->value = $value;
        $this->discountType = $discountType;
        $this->status = $status;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function setValue(float $value): void
    {
        $this->value = $value;
    }

    public function getDiscountType(): string
    {
        return $this->discountType->name;
    }

    public function setDiscountType(CouponDiscountType $discountType): void
    {
        $this->discountType = $discountType;
    }

    public function isInactive(): void
    {
        $this->status = CouponStatus::inactive;
    }

    public function getStatus(): string
    {
        return $this->status->name;
    }
}
