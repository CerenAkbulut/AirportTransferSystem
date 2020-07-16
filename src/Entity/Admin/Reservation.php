<?php

namespace App\Entity\Admin;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Admin\ReservationRepository")
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $userid;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $carsid;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $vehicleid;

    /**
     * @ORM\Column(type="string", length=20 ,nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=20 , nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $fromdest;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $todest;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $total;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $ip;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $message;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $distance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $days;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserid(): ?int
    {
        return $this->userid;
    }

    public function setUserid(?int $userid): self
    {
        $this->userid = $userid;

        return $this;
    }

    public function getCarsid(): ?int
    {
        return $this->carsid;
    }

    public function setCarsid(?int $carsid): self
    {
        $this->carsid = $carsid;

        return $this;
    }

    public function getVehicleid(): ?int
    {
        return $this->vehicleid;
    }

    public function setVehicleid(?int $vehicleid): self
    {
        $this->vehicleid = $vehicleid;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getFromdest(): ?string
    {
        return $this->fromdest;
    }

    public function setFromdest(string $fromdest): self
    {
        $this->fromdest = $fromdest;

        return $this;
    }

    public function getTodest(): ?string
    {
        return $this->todest;
    }

    public function setTodest(string $todest): self
    {
        $this->todest = $todest;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(?string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getDistance(): ?int
    {
        return $this->distance;
    }

    public function setDistance(?int $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(?string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDays(): ?int
    {
        return $this->days;
    }

    public function setDays(?int $days): self
    {
        $this->days = $days;

        return $this;
    }
}
