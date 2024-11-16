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

    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'healthprofessional')]
    private Collection $reservation;

    #[ORM\OneToMany(targetEntity: Availability::class, mappedBy: 'healthprofessional')]
    private Collection $availability;

    #[ORM\ManyToMany(targetEntity: Speciality::class, mappedBy: 'healthprofessional')]
    private Collection $speciality;

    public function __construct()
    {
        $this->consultation = new ArrayCollection();
        $this->reservation = new ArrayCollection();
        $this->availability = new ArrayCollection();
        $this->speciality = new ArrayCollection();
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

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservation(): Collection
    {
        return $this->reservation;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservation->contains($reservation)) {
            $this->reservation->add($reservation);
            $reservation->setHealthprofessional($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservation->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getHealthprofessional() === $this) {
                $reservation->setHealthprofessional(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Availability>
     */
    public function getAvailability(): Collection
    {
        return $this->availability;
    }

    public function addAvailability(Availability $availability): static
    {
        if (!$this->availability->contains($availability)) {
            $this->availability->add($availability);
            $availability->setHealthprofessional($this);
        }

        return $this;
    }

    public function removeAvailability(Availability $availability): static
    {
        if ($this->availability->removeElement($availability)) {
            // set the owning side to null (unless already changed)
            if ($availability->getHealthprofessional() === $this) {
                $availability->setHealthprofessional(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Speciality>
     */
    public function getSpeciality(): Collection
    {
        return $this->speciality;
    }

    public function addSpeciality(Speciality $speciality): static
    {
        if (!$this->speciality->contains($speciality)) {
            $this->speciality->add($speciality);
            $speciality->addHealthprofessional($this);
        }

        return $this;
    }

    public function removeSpeciality(Speciality $speciality): static
    {
        if ($this->speciality->removeElement($speciality)) {
            $speciality->removeHealthprofessional($this);
        }

        return $this;
    }
}
