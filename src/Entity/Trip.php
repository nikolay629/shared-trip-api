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
    private ?float $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;

    #[ORM\Column]
    private ?int $status = null;

    #[Orm\ManyToOne(targetEntity: User::class, inversedBy: 'appliedTrip')]
    private User $user;

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
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float $price
     *
     * @return $this
     */
    public function setPrice(float $price): self
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

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int $status
     *
     * @return $this
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }


    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }


    /**
     * @return array
     */
    public function getData(): array
    {
        $data = [];

        $data['id']         = $this->getId();
        $data['cityFrom']   = $this->getCityFrom();
        $data['cityTo']     = $this->getCityTo();
        $data['hour']       = $this->getHour();
        $data['date']       = $this->getDate();
        $data['seats']      = $this->getSeats();
        $data['price']      = $this->getPrice();
        $data['status']     = $this->getStatus();
        $data['comment']    = $this->getComment();
        $data['user']       = $this->getUser()->getData();

        return $data;
    }

    /**
     * @param array $data
     *
     * @return self
     */
    public function setData(array $data): self
    {
        if (isset($data['cityFrom']) && $data['cityFrom']) {
            $this->setCityFrom($data['cityFrom']);
        }

        if (isset($data['cityTo']) && $data['cityTo']) {
            $this->setCityTo($data['cityTo']);
        }

        if (isset($data['hour']) && $data['hour']) {
            $this->setHour($data['hour']);
        }

        if (isset($data['date']) && $data['date']) {
            $this->setDate($data['date']);
        }

        if (isset($data['seats']) && $data['seats']) {
            $this->setSeats($data['seats']);
        }

        if (isset($data['price']) && $data['price']) {
            $this->setPrice($data['price']);
        }

        if (isset($data['comment']) && $data['comment']) {
            $this->setComment($data['comment']);
        }

        return $this;
    }

}
