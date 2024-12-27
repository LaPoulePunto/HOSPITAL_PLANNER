<?php

namespace App\Entity;

use App\Repository\AvailabilityRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AvailabilityRepository::class)]
class Availability
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank]
    private ?DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotBlank]
    private ?DateTimeInterface $startTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotBlank]
    private ?DateTimeInterface $endTime = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $isRecurring = false;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?string $recurrenceType = null; //1=>touts les jours ouvrables, 2=>toutes les semaines, 3=>touts les mois, 4=> touts les ans

    #[ORM\ManyToOne(inversedBy: 'availability')]
    private ?HealthProfessional $healthProfessional = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getStartTime(): ?DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(DateTimeInterface $startTime): static
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(DateTimeInterface $endTime): static
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getIsRecurring(): ?bool
    {
        return $this->isRecurring;
    }

    public function setIsRecurring(?bool $isRecurring): static
    {
        $this->isRecurring = $isRecurring;
        return $this;
    }

    public function getRecurrenceType(): ?string
    {
        return $this->recurrenceType;
    }

    public function setRecurrenceType(?int $recurrenceType): static
    {
        $this->recurrenceType = $recurrenceType;
        return $this;
    }

    public function getHealthProfessional(): ?HealthProfessional
    {
        return $this->healthProfessional;
    }

    public function setHealthProfessional(?HealthProfessional $healthProfessional): static
    {
        $this->healthProfessional = $healthProfessional;

        return $this;
    }
}
