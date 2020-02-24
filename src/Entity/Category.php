<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="subcategory")
     */
    private $parentCategory;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Category", mappedBy="parentCategory")
     */
    private $subcategory;

    public function __construct()
    {
        $this->subcategory = new ArrayCollection();
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

    public function getParentCategory(): ?self
    {
        return $this->parentCategory;
    }

    public function setParentCategory(?self $parentCategory): self
    {
        $this->parentCategory = $parentCategory;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getSubcategory(): Collection
    {
        return $this->subcategory;
    }

    public function addSubcategory(self $subcategory): self
    {
        if (!$this->subcategory->contains($subcategory)) {
            $this->subcategory[] = $subcategory;
            $subcategory->setParentCategory($this);
        }

        return $this;
    }

    public function removeSubcategory(self $subcategory): self
    {
        if ($this->subcategory->contains($subcategory)) {
            $this->subcategory->removeElement($subcategory);
            // set the owning side to null (unless already changed)
            if ($subcategory->getParentCategory() === $this) {
                $subcategory->setParentCategory(null);
            }
        }

        return $this;
    }
}
