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
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Wilder::class, inversedBy="wilderHasSkills")
     * @ORM\JoinColumn(nullable=false)
     */
    private $wilders;

    /**
     * @ORM\ManyToOne(targetEntity=Skill::class, inversedBy="wilderHasSkills")
     * @ORM\JoinColumn(nullable=false)
     */
    private $skills;

    /**
     * @ORM\Column(type="integer")
     */
    private $rate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWilders(): ?Wilder
    {
        return $this->wilders;
    }

    public function setWilders(?Wilder $wilders): self
    {
        $this->wilders = $wilders;

        return $this;
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
