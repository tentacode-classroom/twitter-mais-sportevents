<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RetweetRepository")
 */
class Retweet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="retweets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Message", inversedBy="retweets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $retweetedMessage;

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

    public function getRetweetedMessage(): ?Message
    {
        return $this->retweetedMessage;
    }

    public function setRetweetedMessage(?Message $retweetedMessage): self
    {
        $this->retweetedMessage = $retweetedMessage;

        return $this;
    }
}
