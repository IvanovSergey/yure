<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoriesRepository")
 */
class Categories
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
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $parentId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $seo_path;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enable;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Statements", mappedBy="category_id")
     */
    private $statements;

    public function __construct()
    {
        $this->statements = new ArrayCollection();
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

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    public function setParentId(?int $parentId): self
    {
        $this->parentId = $parentId;

        return $this;
    }

    public function getSeoPath(): ?string
    {
        return $this->seo_path;
    }

    public function setSeoPath(string $seo_path): self
    {
        $this->seo_path = $seo_path;

        return $this;
    }

    public function getEnable(): ?bool
    {
        return $this->enable;
    }

    public function setEnable(bool $enable): self
    {
        $this->enable = $enable;

        return $this;
    }

    /**
     * @return Collection|Statements[]
     */
    public function getStatements(): Collection
    {
        return $this->statements;
    }

    public function addStatement(Statements $statement): self
    {
        if (!$this->statements->contains($statement)) {
            $this->statements[] = $statement;
            $statement->setCategoryId($this);
        }

        return $this;
    }

    public function removeStatement(Statements $statement): self
    {
        if ($this->statements->contains($statement)) {
            $this->statements->removeElement($statement);
            // set the owning side to null (unless already changed)
            if ($statement->getCategoryId() === $this) {
                $statement->setCategoryId(null);
            }
        }

        return $this;
    }
}
