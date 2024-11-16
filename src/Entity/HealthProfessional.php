<?php

namespace App\Entity;

use App\Repository\HealthProfessionalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HealthProfessionalRepository::class)]
class HealthProfessional extends User
{
    #[ORM\Column(length: 32)]
    private ?string $job = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $hiringDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $departureDate = null;

    #[ORM\OneToMany(targetEntity: Consultation::class, mappedBy: 'healthprofessional')]
    private Collection $consultation;

    public function __construct()
    {
        $this->consultation = new ArrayCollection();
    }

    public function getJob(): ?string
    {
        return $this->job;
    }

    public function setJob(string $job): static
    {
        $this->job = $job;

        return $this;
    }

    public function getHiringDate(): ?\DateTimeInterface
    {
        return $this->hiringDate;
    }

    public function setHiringDate(?\DateTimeInterface $hiringDate): static
    {
        $this->hiringDate = $hiringDate;

        return $this;
    }

    public function getDepartureDate(): ?\DateTimeInterface
    {
        return $this->departureDate;
    }

    public function setDepartureDate(?\DateTimeInterface $departureDate): static
    {
        $this->departureDate = $departureDate;

        return $this;
    }

    /**
     * @return Collection<int, Consultation>
     */
    public function getConsultation(): Collection
    {
        return $this->consultation;
    }

    public function addConsultation(Consultation $consultation): static
    {
        if (!$this->consultation->contains($consultation)) {
            $this->consultation->add($consultation);
            $consultation->setHealthprofessional($this);
        }

        return $this;
    }

    public function removeConsultation(Consultation $consultation): static
    {
        if ($this->consultation->removeElement($consultation)) {
            // set the owning side to null (unless already changed)
            if ($consultation->getHealthprofessional() === $this) {
                $consultation->setHealthprofessional(null);
            }
        }

        return $this;
    }
}
