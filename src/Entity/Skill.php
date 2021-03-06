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
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;

    /**
     * @ORM\OneToMany(targetEntity=WilderHasSkill::class, mappedBy="skills")
     */
    private Collection $wilderHasSkills;

    public function __construct()
    {
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

    public function __toString(): ?string
    {
        return $this->getName();
    }
}
