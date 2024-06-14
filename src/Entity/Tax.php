<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TaxRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaxRepository::class)]
class Tax
{
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private int $id;

    #[ORM\Column(name: 'country', type: 'string', nullable: false)]
    private string $country;

    #[ORM\Column(name: 'interest_rate', type: 'float', nullable: false)]
    private float $interestRate;

    #[ORM\Column(name: 'format', type: 'string', nullable: false)]
    private string $format;


    public function __construct(
        string $country,
        float $interestRate,
        string $format,
    ) {
        $this->country = $country;
        $this->interestRate = $interestRate;
        $this->format = $format;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function getInterestRate(): float
    {
        return $this->interestRate;
    }

    public function setInterestRate(float $interestRate): void
    {
        $this->interestRate = $interestRate;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function setFormat(string $format): void
    {
        $this->format = $format;
    }
}
