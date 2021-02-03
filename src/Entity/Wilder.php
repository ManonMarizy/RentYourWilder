<?php

namespace App\Entity;

use App\Repository\WilderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WilderRepository::class)
 */
class Wilder
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private string $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isAvailable;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isEnable;

    /**
     * @ORM\OneToMany(targetEntity=WilderHasSkill::class, mappedBy="wilders", orphanRemoval=true)
     */
    private Collection $wilderHasSkills;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="wilder")
     */
    private Collection $userId;

    public function __construct()
    {
        $this->wilderHasSkills = new ArrayCollection();
        $this->userId = new ArrayCollection();
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

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): self
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsEnable()
    {
        return $this->isEnable;
    }

    /**
     * @param mixed $isEnable
     */
    public function setIsEnable($isEnable): void
    {
        $this->isEnable = $isEnable;
    }

    /**
     * @return Collection|WilderHasSkill[]
     */
    public function getWilderHasSkills(): Collection
    {
        return $this->wilderHasSkills;
    }

    public function addWilderHasSkill(WilderHasSkill $wilderHasSkill): self
    {
        if (!$this->wilderHasSkills->contains($wilderHasSkill)) {
            $this->wilderHasSkills[] = $wilderHasSkill;
            $wilderHasSkill->setWilders($this);
        }

        return $this;
    }

    public function removeWilderHasSkill(WilderHasSkill $wilderHasSkill): self
    {
        if ($this->wilderHasSkills->removeElement($wilderHasSkill)) {
            // set the owning side to null (unless already changed)
            if ($wilderHasSkill->getWilders() === $this) {
                $wilderHasSkill->setWilders(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUserId(): Collection
    {
        return $this->userId;
    }

    public function addUserId(User $userId): self
    {
        if (!$this->userId->contains($userId)) {
            $this->userId[] = $userId;
            $userId->setWilder($this);
        }

        return $this;
    }

    public function removeUserId(User $userId): self
    {
        if ($this->userId->removeElement($userId)) {
            // set the owning side to null (unless already changed)
            if ($userId->getWilder() === $this) {
                $userId->setWilder(null);
            }
        }

        return $this;
    }
}
