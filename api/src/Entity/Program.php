<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProgramRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of a program holding exercises.
 * */
#[ORM\Entity(repositoryClass: ProgramRepository::class)]
#[ApiResource]
class Program
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $frequency = null;

    #[ORM\Column]
    private ?int $duration = null;

    /**
     * @var Collection<int, Training>
     */
    #[ORM\OneToMany(targetEntity: Training::class, mappedBy: 'program')]
    private Collection $training;

    public function __construct()
    {
        $this->training = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getFrequency(): ?int
    {
        return $this->frequency;
    }

    public function setFrequency(int $frequency): static
    {
        $this->frequency = $frequency;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return Collection<int, Training>
     */
    public function getTraining(): Collection
    {
        return $this->training;
    }

    public function addTraining(Training $training): static
    {
        if (!$this->training->contains($training)) {
            $this->training->add($training);
            $training->setProgram($this);
        }

        return $this;
    }

    public function removeTraining(Training $training): static
    {
        if ($this->training->removeElement($training)) {
            // set the owning side to null (unless already changed)
            if ($training->getProgram() === $this) {
                $training->setProgram(null);
            }
        }

        return $this;
    }
}
