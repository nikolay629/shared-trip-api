<?php

namespace App\Entity;

use App\Repository\AppliedTripRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class AppliedTrip
 */
#[ORM\Entity(repositoryClass: AppliedTripRepository::class)]
class AppliedTrip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Orm\ManyToOne(targetEntity: Trip::class, inversedBy: 'appliedTrip')]
    private Trip $trip;

    #[Orm\ManyToOne(targetEntity: User::class, inversedBy: 'appliedTrip')]
    private User $user;

    #[ORM\Column]
    private ?int $status;

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

    /**
     * @return int?
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
}
