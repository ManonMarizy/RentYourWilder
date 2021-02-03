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
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isAvailable;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isEnable;

    /**
     * @ORM\OneToMany(targetEntity=Skill::class, mappedBy="wilder", orphanRemoval=true)
     */
    private $hasSkills;

    /**
     * @ORM\ManyToOne(targetEntity=Skill::class, inversedBy="hasWilders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $skill;

    /**
     * @ORM\OneToMany(targetEntity=WilderHasSkill::class, mappedBy="wilders", orphanRemoval=true)
     */
    private $wilderHasSkills;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="wilder")
     */
    private $userId;

    public function __construct()
    {
        $this->hasSkills = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
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
     * @return Collection|Skill[]
     */
    public function getHasSkills(): Collection
    {
        return $this->hasSkills;
    }

    public function addHasSkill(Skill $hasSkill): self
    {
        if (!$this->hasSkills->contains($hasSkill)) {
            $this->hasSkills[] = $hasSkill;
            $hasSkill->setWilder($this);
        }

        return $this;
    }

    public function removeHasSkill(Skill $hasSkill): self
    {
        if ($this->hasSkills->removeElement($hasSkill)) {
            // set the owning side to null (unless already changed)
            if ($hasSkill->getWilder() === $this) {
                $hasSkill->setWilder(null);
            }
        }

        return $this;
    }

    public function getSkill(): ?Skill
    {
        return $this->skill;
    }

    public function setSkill(?Skill $skill): self
    {
        $this->skill = $skill;

        return $this;
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
