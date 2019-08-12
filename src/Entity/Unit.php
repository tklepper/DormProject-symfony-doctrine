<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\User;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UnitRepository")
 */
class Unit
{ 
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $building_number;

    /**
     * @ORM\Column(type="integer")
     */
    private $floor_number;

    /**
     * @ORM\Column(type="integer")
     */
    private $room_number;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="unit")
     */
    private $users;

    public function __construct(){
        $this->users = new ArrayCollection();
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBuildingNumber(): ?int
    {
        return $this->building_number;
    }

    public function setBuildingNumber(int $building_number): self
    {
        $this->building_number = $building_number;

        return $this;
    }

    public function getFloorNumber(): ?int
    {
        return $this->floor_number;
    }

    public function setFloorNumber(int $floor_number): self
    {
        $this->floor_number = $floor_number;

        return $this;
    }

    public function getRoomNumber(): ?int
    {
        return $this->room_number;
    }

    public function setRoomNumber(int $room_number): self
    {
        $this->room_number = $room_number;

        return $this;
    }
}
