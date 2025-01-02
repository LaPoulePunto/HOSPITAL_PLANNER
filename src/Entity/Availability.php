<?php

namespace App\Entity;

use App\Repository\AvailabilityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?string $recurrenceType = null;
    /*
        'Aucune' => null,
        'Toutes les semaines' => 1,
        'Touts les mois' => 2,
        'Tous les ans' => 3,
    */

    #[ORM\ManyToOne(inversedBy: 'availability')]
    #[Assert\NotBlank]
    private ?HealthProfessional $healthProfessional = null;

    #[ORM\OneToMany(targetEntity: AvailabilitySplitSlots::class, mappedBy: 'availability')]
    private Collection $availabilitySplitSlots;

    public function __construct()
    {
        $this->availabilitySplitSlots = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, AvailabilitySplitSlots>
     */
    public function getAvailabilitySplitSlots(): Collection
    {
        return $this->availabilitySplitSlots;
    }

    public function addAvailabilitySplitSlot(AvailabilitySplitSlots $availabilitySplitSlot): static
    {
        if (!$this->availabilitySplitSlots->contains($availabilitySplitSlot)) {
            $this->availabilitySplitSlots->add($availabilitySplitSlot);
            $availabilitySplitSlot->setAvailability($this);
        }

        return $this;
    }

    public function removeAvailabilitySplitSlot(AvailabilitySplitSlots $availabilitySplitSlot): static
    {
        if ($this->availabilitySplitSlots->removeElement($availabilitySplitSlot)) {
            if ($availabilitySplitSlot->getAvailability() === $this) {
                $availabilitySplitSlot->setAvailability(null);
            }
        }

        return $this;
    }
}
