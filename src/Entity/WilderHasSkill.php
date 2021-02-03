<?php

namespace App\Entity;

use App\Repository\WilderHasSkillRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WilderHasSkillRepository::class)
 */
class WilderHasSkill
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Wilder::class, inversedBy="wilderHasSkills")
     * @ORM\JoinColumn(nullable=false)
     */
    private Wilder $wilders;

    /**
     * @ORM\ManyToOne(targetEntity=Skill::class, inversedBy="wilderHasSkills", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private Skill $skills;

    /**
     * @ORM\Column(type="integer")
     */
    private int $rate;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Wilder
     */
    public function getWilders(): Wilder
    {
        return $this->wilders;
    }

    /**
     * @param Wilder $wilders
     */
    public function setWilders(Wilder $wilders): void
    {
        $this->wilders = $wilders;
    }

    public function getSkills(): ?Skill
    {
        return $this->skills;
    }

    public function setSkills(?Skill $skills): self
    {
        $this->skills = $skills;

        return $this;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(int $rate): self
    {
        $this->rate = $rate;

        return $this;
    }
}
