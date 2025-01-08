<?php

namespace App\Entity;

use App\Repository\ConsultationRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConsultationRepository::class)]
class Consultation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?DateTimeInterface $startTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?DateTimeInterface $endTime = null;

    #[ORM\ManyToOne(inversedBy: 'consultation')]
    private ?Room $room = null;

    #[ORM\ManyToOne(inversedBy: 'consultation')]
    private ?ConsultationType $consultationType = null;

    #[ORM\ManyToOne(inversedBy: 'consultation')]
    private ?Patient $patient = null;

    #[ORM\ManyToMany(targetEntity: HealthProfessional::class, inversedBy: 'consultation')]
    private Collection $healthProfessional;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $prescription = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $signature = null;

    public function __construct()
    {
        $this->healthProfessional = new ArrayCollection();
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

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): static
    {
        $this->room = $room;

        return $this;
    }

    public function getConsultationtype(): ?ConsultationType
    {
        return $this->consultationType;
    }

    public function setConsultationtype(?ConsultationType $consultationtype): static
    {
        $this->consultationType = $consultationtype;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): static
    {
        $this->patient = $patient;

        return $this;
    }

    public function getHealthprofessional(): Collection
    {
        return $this->healthProfessional;
    }

    public function addHealthprofessional(HealthProfessional $healthprofessional): static
    {
        if (!$this->healthProfessional->contains($healthprofessional)) {
            $this->healthProfessional->add($healthprofessional);
        }

        return $this;
    }

    public function removeHealthprofessional(HealthProfessional $healthprofessional): static
    {
        $this->healthProfessional->removeElement($healthprofessional);

        return $this;
    }

    public function getPrescription(): ?string
    {
        return $this->prescription;
    }

    public function setPrescription(?string $prescription): static
    {
        $this->prescription = $prescription;

        return $this;
    }

    public function getSignature()
    {
        return $this->signature;
    }

    public function setSignature($signature): static
    {
        $this->signature = $signature;

        return $this;
    }
}
