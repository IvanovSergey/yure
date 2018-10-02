<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StatementsRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Statements
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
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $update_date;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enable;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $seo_path;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categories", inversedBy="statements")
     */
    private $category_id;

    const SERVER_PATH_TO_IMAGE_FOLDER = __DIR__ . '/../../public/upload/screenshots';
    
    /**
     * @ORM\Column(type="string")
     *
     * @Assert\File()
     */
    private $screenshot;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StatementComments", mappedBy="statement")
     */
    private $statementComments;

    public function __construct()
    {
        $this->category_id = new ArrayCollection();
        $this->statementComments = new ArrayCollection();
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getUpdateDate(): ?\DateTimeInterface
    {
        return $this->update_date;
    }

    public function setUpdateDate(\DateTimeInterface $update_date): self
    {
        $this->update_date = $update_date;

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

    public function getSeoPath(): ?string
    {
        return $this->seo_path;
    }

    public function setSeoPath(string $seo_path): self
    {
        $this->seo_path = $seo_path;

        return $this;
    }

    public function getCategoryId()
    { 
        return $this->category_id;
    }

    public function setCategoryId(?Categories $category_id): self
    {
        $this->category_id = $category_id;

        return $this;
    }
    
    public function getScreenshot()
    {
        return $this->screenshot;
    }
    
    public function setScreenshot($screenshot): self
    { 
        $this->screenshot = $screenshot;

        return $this;
    }
    
    /**
    * @ORM\PrePersist
    * @ORM\PreUpdate
    */
    public function upload()
    {  
        // the file property can be empty if the field is not required
        if (null === $this->getScreenshot() || !method_exists($this->getScreenshot(), 'getClientOriginalName')) { 
            if(!empty($this->getScreenshot())){
                $screenshot_path = explode('/', $this->getScreenshot());
                $screenshot_path = end($screenshot_path);
                $this->setScreenshot($screenshot_path);
            }
        } else {
            // we use the original file name here but you should
            // sanitize it at least to avoid any security issues
            // move takes the target directory and target filename as params
            $this->getScreenshot()->move(
                self::SERVER_PATH_TO_IMAGE_FOLDER,
                $this->getScreenshot()->getClientOriginalName()
            );

            // set the path property to the filename where you've saved the file
            $this->filename = $this->getScreenshot()->getClientOriginalName();

            // clean up the file property as you won't need it anymore

            $this->setScreenshot($this->filename);
        }
    }
    
    /**
    * Lifecycle callback to upload the file to the server
    */
   public function lifecycleFileUpload()
   {
       $this->upload();
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
           $statementComment->setStatement($this);
       }

       return $this;
   }

   public function removeStatementComment(StatementComments $statementComment): self
   {
       if ($this->statementComments->contains($statementComment)) {
           $this->statementComments->removeElement($statementComment);
           // set the owning side to null (unless already changed)
           if ($statementComment->getStatement() === $this) {
               $statementComment->setStatement(null);
           }
       }

       return $this;
   }
}
