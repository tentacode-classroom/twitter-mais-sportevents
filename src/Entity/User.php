<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * 
 * @UniqueEntity(
 *  fields={"email"},
 *  message="Cette adresse e-mail est déjà utilisée pour un autre compte"
 * )
 * @UniqueEntity(
 *  fields={"username"},
 *  message="Ce nom d'utilisateur est déjà utilisé pour un autre compte"
 * )

 */
class User implements UserInterface , \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $username;

    /**
     * @ORM\Column(type="simple_array")
     */
    private $roles = ['ROLE_USER'];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="user", cascade={"persist"})
     */
    private $messages;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Message", inversedBy="likes")
     */
    private $message;

 

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="S'il vous plait veuillez telecharger un fichier image.")
     * @Assert\File(mimeTypes={ "image/jpeg", "image/jpg", "image/png" })
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Friend", mappedBy="follower")
     */
    private $friends;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Friend", mappedBy="following")
     */
    private $myFollowers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Retweet", mappedBy="user")
     */
    private $retweets;




    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->friends = new ArrayCollection();
        $this->follower = new ArrayCollection();
        $this->retweets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized, array('allowed_classes' => false));
    }



    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setUser($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getUser() === $this) {
                $message->setUser(null);
            }
        }

        return $this;
    }
    
    public function likeMessage(Message $message): self
    {
      $message-> addLike($this);
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
     * @return Collection|Friend[]
     */
    public function getFriends(): Collection
    {
        return $this->friends;
    }

    public function addFriend(Friend $friend): self
    {
        if (!$this->friends->contains($friend)) {
            $this->friends[] = $friend;
            $friend->setFollower($this);
        }

        return $this;
    }

    public function removeFriend(Friend $friend): self
    {
        if ($this->friends->contains($friend)) {
            $this->friends->removeElement($friend);
            // set the owning side to null (unless already changed)
            if ($friend->getFollower() === $this) {
                $friend->setFollower(null);
            }
        }

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
            $retweet->setUser($this);
        }

        return $this;
    }

    public function removeRetweet(Retweet $retweet): self
    {
        if ($this->retweets->contains($retweet)) {
            $this->retweets->removeElement($retweet);
            // set the owning side to null (unless already changed)
            if ($retweet->getUser() === $this) {
                $retweet->setUser(null);
            }
        }

        return $this;
    }



 
}
