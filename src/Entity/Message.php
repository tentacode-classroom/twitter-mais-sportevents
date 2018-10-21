<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
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
     *  @Assert\Length(
     *      max = 280,
     *      maxMessage = "Votre mot de passe est trop long : max {{ limit }} caractères"
     * )
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


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Retweet", mappedBy="retweetedMessage")
     */
    private $retweets;

      /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\File(mimeTypes={ "image/jpeg", "image/jpg", "image/png" })
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="message", cascade={"persist"})
     */
    private $comments;


    public function __construct()
    {
        $this->likes = new ArrayCollection();
        $this->peopleWhoLiked = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->retweets = new ArrayCollection();
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


    /**
     * @return Collection|Retweet[]
     */
    public function getRetweets(): Collection
    {
        return $this->retweets;
    }

    public function addRetweet(Retweet $retweet): self
    {
        if (!$this->retweets->contains($retweet)) {
            $this->retweets[] = $retweet;
            $retweet->setRetweetedMessage($this);
        }

        return $this;
    }

    public function removeRetweet(Retweet $retweet): self
    {
        if ($this->retweets->contains($retweet)) {
            $this->retweets->removeElement($retweet);
            // set the owning side to null (unless already changed)
            if ($retweet->getRetweetedMessage() === $this) {
                $retweet->setRetweetedMessage(null);
            }
        }

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setMessage($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getMessage() === $this) {
                $comment->setMessage(null);
            }
        }

        return $this;
    }


}
