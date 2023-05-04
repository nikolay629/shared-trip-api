<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\ConfirmTripRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ConfirmTrip
 */
#[ORM\Entity(repositoryClass: ConfirmTripRepository::class)]
class ConfirmTrip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Orm\ManyToOne(targetEntity: Trip::class, inversedBy: 'appliedTrip')]
    private Trip $trip;

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
     * @return Trip
     */
    public function getTrip(): Trip
    {
        return $this->trip;
    }

    /**
     * @param Trip $trip
     *
     * @return $this
     */
    public function setTrip(Trip $trip): self
    {
        $this->trip = $trip;

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
}
