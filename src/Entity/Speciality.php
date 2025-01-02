<?php

namespace App\Entity;

use App\Repository\SpecialityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpecialityRepository::class)]
class Speciality
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 32)]
    private ?string $label = null;

    #[ORM\ManyToMany(targetEntity: HealthProfessional::class, inversedBy: 'speciality')]
    private Collection $healthProfessional;

    public function __construct()
    {
        $this->healthProfessional = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, HealthProfessional>
     */
    public function getHealthProfessional(): Collection
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
}
