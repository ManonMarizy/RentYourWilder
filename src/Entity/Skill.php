<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SkillRepository::class)
 */
class Skill
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
     * @ORM\ManyToOne(targetEntity=Wilder::class, inversedBy="hasSkills")
     * @ORM\JoinColumn(nullable=false)
     */
    private $wilder;

    /**
     * @ORM\OneToMany(targetEntity=Wilder::class, mappedBy="skill", orphanRemoval=true)
     */
    private $hasWilders;

    /**
     * @ORM\OneToMany(targetEntity=WilderHasSkill::class, mappedBy="skills")
     */
    private $wilderHasSkills;

    public function __construct()
    {
        $this->hasWilders = new ArrayCollection();
        $this->wilderHasSkills = new ArrayCollection();
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

    public function getWilder(): ?Wilder
    {
        return $this->wilder;
    }

    public function setWilder(?Wilder $wilder): self
    {
        $this->wilder = $wilder;

        return $this;
    }

    /**
     * @return Collection|Wilder[]
     */
    public function getHasWilders(): Collection
    {
        return $this->hasWilders;
    }

    public function addHasWilder(Wilder $hasWilder): self
    {
        if (!$this->hasWilders->contains($hasWilder)) {
            $this->hasWilders[] = $hasWilder;
            $hasWilder->setSkill($this);
        }

        return $this;
    }

    public function removeHasWilder(Wilder $hasWilder): self
    {
        if ($this->hasWilders->removeElement($hasWilder)) {
            // set the owning side to null (unless already changed)
            if ($hasWilder->getSkill() === $this) {
                $hasWilder->setSkill(null);
            }
        }

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
            $wilderHasSkill->setSkills($this);
        }

        return $this;
    }

    public function removeWilderHasSkill(WilderHasSkill $wilderHasSkill): self
    {
        if ($this->wilderHasSkills->removeElement($wilderHasSkill)) {
            // set the owning side to null (unless already changed)
            if ($wilderHasSkill->getSkills() === $this) {
                $wilderHasSkill->setSkills(null);
            }
        }

        return $this;
    }
}
