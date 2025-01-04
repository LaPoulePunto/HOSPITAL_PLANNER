<?php

namespace App\Entity;

use App\Repository\RoomTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomTypeRepository::class)]
class RoomType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 32)]
    private ?string $label = null;

    #[ORM\OneToMany(targetEntity: Room::class, mappedBy: 'roomtype')]
    private Collection $room;

    #[ORM\OneToMany(targetEntity: ConsultationType::class, mappedBy: 'roomType')]
    private Collection $consultationTypes;

    public function __construct()
    {
        $this->room = new ArrayCollection();
        $this->consultationTypes = new ArrayCollection();
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
     * @return Collection<int, Room>
     */
    public function getRoom(): Collection
    {
        return $this->room;
    }

    public function addRoom(Room $room): static
    {
        if (!$this->room->contains($room)) {
            $this->room->add($room);
            $room->setRoomType($this);
        }

        return $this;
    }

    public function removeRoom(Room $room): static
    {
        if ($this->room->removeElement($room)) {
            // set the owning side to null (unless already changed)
            if ($room->getRoomType() === $this) {
                $room->setRoomType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ConsultationType>
     */
    public function getConsultationTypes(): Collection
    {
        return $this->consultationTypes;
    }

    public function addConsultationType(ConsultationType $consultationType): static
    {
        if (!$this->consultationTypes->contains($consultationType)) {
            $this->consultationTypes->add($consultationType);
            $consultationType->setRoomType($this);
        }

        return $this;
    }

    public function removeConsultationType(ConsultationType $consultationType): static
    {
        if ($this->consultationTypes->removeElement($consultationType)) {
            // set the owning side to null (unless already changed)
            if ($consultationType->getRoomType() === $this) {
                $consultationType->setRoomType(null);
            }
        }

        return $this;
    }
}
