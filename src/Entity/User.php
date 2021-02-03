<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private string $email;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private string $password;


    /**
     * @ORM\OneToMany(targetEntity=Wilder::class, mappedBy="user")
     */
    private Collection $wilders;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private bool $isActivate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $token;

    public function __construct()
    {
        $this->wilders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }


    public function getIsActivate(): ?bool
    {
        return $this->isActivate;
    }

    public function setIsActivate(bool $isActivate): self
    {
        $this->isActivate = $isActivate;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getWilders()
    {
        return $this->wilders;
    }

    /**
     * @param ArrayCollection|Collection $wilders
     */
    public function setWilders($wilders): void
    {
        $this->wilders = $wilders;
    }

    public function addWilder(Wilder $wilder): self
    {
        if (!$this->wilders->contains($wilder)) {
            $this->wilders[] = $wilder;
            $wilder->setUser($this);
        }

        return $this;
    }

    public function removeWilder(Wilder $wilder): self
    {
        if ($this->wilders->removeElement($wilder)) {
            // set the owning side to null (unless already changed)
            if ($wilder->getUser() === $this) {
                $wilder->setUser(null);
            }
        }

        return $this;
    }

}
