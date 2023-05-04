<?php

namespace App\Entity;

use App\Repository\TripRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Trip
 */
#[ORM\Entity(repositoryClass: TripRepository::class)]
class Trip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $cityFrom = null;

    #[ORM\Column(length: 255)]
    private ?string $cityTo = null;

    #[ORM\Column(length: 255)]
    private ?string $hour = null;

    #[ORM\Column(length: 255)]
    private ?string $date = null;

    #[ORM\Column]
    private ?int $seats = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;

    #[ORM\OneToMany(mappedBy: 'trip', targetEntity: AppliedTrip::class)]
    private AppliedTrip $appliedTrip;

    #[ORM\OneToMany(mappedBy: 'trip', targetEntity: ConfirmTrip::class)]
    private ConfirmTrip $confirmTrip;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getCityFrom(): ?string
    {
        return $this->cityFrom;
    }

    /**
     * @param string $cityFrom
     *
     * @return $this
     */
    public function setCityFrom(string $cityFrom): self
    {
        $this->cityFrom = $cityFrom;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCityTo(): ?string
    {
        return $this->cityTo;
    }

    /**
     * @param string $cityTo
     *
     * @return $this
     */
    public function setCityTo(string $cityTo): self
    {
        $this->cityTo = $cityTo;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHour(): ?string
    {
        return $this->hour;
    }

    /**
     * @param string $hour
     *
     * @return $this
     */
    public function setHour(string $hour): self
    {
        $this->hour = $hour;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @param string $date
     *
     * @return $this
     */
    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getSeats(): ?int
    {
        return $this->seats;
    }

    /**
     * @param int $seats
     *
     * @return $this
     */
    public function setSeats(int $seats): self
    {
        $this->seats = $seats;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrice(): ?string
    {
        return $this->price;
    }

    /**
     * @param string $price
     *
     * @return $this
     */
    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param string|null $comment
     *
     * @return $this
     */
    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }
}
