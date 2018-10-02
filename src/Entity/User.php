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
    private $statementComments;

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
}