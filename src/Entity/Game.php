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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $partyTime;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Rating", mappedBy="game")
     */
    private $ratings;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="games")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Borrow", mappedBy="game")
     */
    private $borrows;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isBorrowed = false;

    public function __construct()
    {
        $this->ratings = new ArrayCollection();
        $this->borrows = new ArrayCollection();
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

    public function getPartyTime(): ?int
    {
        return $this->partyTime;
    }

    public function setPartyTime(?int $partyTime): self
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Borrow[]
     */
    public function getBorrows(): Collection
    {
        return $this->borrows;
    }

    public function addBorrow(Borrow $borrow): self
    {
        if (!$this->borrows->contains($borrow)) {
            $this->borrows[] = $borrow;
            $borrow->setGame($this);
        }

        return $this;
    }

    public function removeBorrow(Borrow $borrow): self
    {
        if ($this->borrows->contains($borrow)) {
            $this->borrows->removeElement($borrow);
            // set the owning side to null (unless already changed)
            if ($borrow->getGame() === $this) {
                $borrow->setGame(null);
            }
        }

        return $this;
    }

    public function checkIfBorrowed() {
        $this->borrows->filter(function(Borrow $borrow) {
            return !$borrow->getIsReturned();
        });
    }

    public function getIsBorrowed(): ?bool
    {
        return $this->isBorrowed;
    }

    public function setIsBorrowed(bool $isBorrowed): self
    {
        $this->isBorrowed = $isBorrowed;

        return $this;
    }

    public function __toString() {
        return $this->getName();
    }
}
