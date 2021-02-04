<?php

namespace App\Entity;

use App\Repository\WilderRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=WilderRepository::class)
 * @Vich\Uploadable
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
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="wilders")
     */
    private ?User $user;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $avatar;

    /**
     * @Assert\Image(
     *     maxSize = "2048k",
     *     mimeTypesMessage = "L'image est invalide"
     * )
     * @Vich\UploadableField(mapping="avatar_file", fileNameProperty="avatar")
     * @var ?File
     */
    private  ?File $avatarFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var Datetime
     */
    private DateTime $updatedAt;

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
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param ?User $user
     */
    public function setUser(?User $user): void
    {
        if ($user) {
            $this->user = $user;
        }
        $this->user = null;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function setAvatarFile(File $image = null): Wilder
    {
        $this->avatarFile = $image;
        if ($image) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    public function getAvatarFile(): File
    {
        return $this->avatarFile;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
