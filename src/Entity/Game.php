<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=400, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=400, nullable=true)
     */
    private $imageUrl;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $recommendedAge;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $partyTime;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Rating", mappedBy="game")
     */
    private $ratings;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="games")
     */
    private $users;

    public function __construct()
    {
        $this->ratings = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getRecommendedAge(): ?int
    {
        return $this->recommendedAge;
    }

    public function setRecommendedAge(?int $recommendedAge): self
    {
        $this->recommendedAge = $recommendedAge;

        return $this;
    }

    public function getPartyTime(): ?\DateTimeInterface
    {
        return $this->partyTime;
    }

    public function setPartyTime(?\DateTimeInterface $partyTime): self
    {
        $this->partyTime = $partyTime;

        return $this;
    }

    /**
     * @return Collection|Rating[]
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(Rating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings[] = $rating;
            $rating->setGame($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): self
    {
        if ($this->ratings->contains($rating)) {
            $this->ratings->removeElement($rating);
            // set the owning side to null (unless already changed)
            if ($rating->getGame() === $this) {
                $rating->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addGame($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeGame($this);
        }

        return $this;
    }
}
