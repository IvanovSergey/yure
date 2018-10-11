<?php
// src/Entity/User.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StatementComments", mappedBy="user")
     */
    protected $statementComments;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $First_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $Second_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $Middle_name;

    public function __construct()
    {
        parent::__construct();
        $this->statementComments = new ArrayCollection();
        // your own logic
    }

    /**
     * @return Collection|StatementComments[]
     */
    public function getStatementComments(): Collection
    {
        return $this->statementComments;
    }

    public function addStatementComment(StatementComments $statementComment): self
    {
        if (!$this->statementComments->contains($statementComment)) {
            $this->statementComments[] = $statementComment;
            $statementComment->setUser($this);
        }

        return $this;
    }

    public function removeStatementComment(StatementComments $statementComment): self
    {
        if ($this->statementComments->contains($statementComment)) {
            $this->statementComments->removeElement($statementComment);
            // set the owning side to null (unless already changed)
            if ($statementComment->getUser() === $this) {
                $statementComment->setUser(null);
            }
        }

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->First_name;
    }

    public function setFirstName(?string $First_name): self
    {
        $this->First_name = $First_name;

        return $this;
    }

    public function getSecondName(): ?string
    {
        return $this->Second_name;
    }

    public function setSecondName(?string $Second_name): self
    {
        $this->Second_name = $Second_name;

        return $this;
    }

    public function getMiddleName(): ?string
    {
        return $this->Middle_name;
    }

    public function setMiddleName(?string $Middle_name): self
    {
        $this->Middle_name = $Middle_name;

        return $this;
    }
}