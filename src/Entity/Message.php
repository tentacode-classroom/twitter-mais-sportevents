<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
 */
class Message
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Like", mappedBy="message")
     */
    private $likes;

    /**
     * @ORM\Column(type="datetime")
     */
    private $publicationDate;
  
    public function __construct()
    {
        $this->likes = new ArrayCollection();
        $this->peopleWhoLiked = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection|Like[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Like $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setMessage($this);
        }

        return $this;
    }

    public function removeLike(Like $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            // set the owning side to null (unless already changed)
            if ($like->getMessage() === $this) {
                $like->setMessage(null);
            }
        }

        return $this;
    }
    public function getPeopleWhoLiked()
    {
        $peopleWhoLiked = new ArrayCollection();
        foreach ( $this->getLikes() as $like) {
            $peopleWhoLiked[]= $like->getUser();
        }
       
        return $peopleWhoLiked;
    }

    public function getUserLike(User $user): Like
    {
        foreach ( $this->getLikes() as $like) {
            if ($like -> getUser()==$user){
                return $like;
                continue;
            }
        }
        return null;
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publicationDate;
    }

    
    public function setPublicationDate(\DateTimeInterface $publicationDate): self
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }
}
