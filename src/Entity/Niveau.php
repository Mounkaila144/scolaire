<?php

namespace App\Entity;

use App\Repository\NiveauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NiveauRepository::class)]
class Niveau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $annee = null;

    #[ORM\Column]
    private ?int $scolariter = null;

    #[ORM\OneToMany(mappedBy: 'niveau', targetEntity: Fillier::class)]
    private Collection $filliers;

    public function __construct()
    {
        $this->filliers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getScolariter(): ?int
    {
        return $this->scolariter;
    }

    public function setScolariter(int $scolariter): self
    {
        $this->scolariter = $scolariter;

        return $this;
    }

    /**
     * @return Collection<int, Fillier>
     */
    public function getFilliers(): Collection
    {
        return $this->filliers;
    }

    public function addFillier(Fillier $fillier): self
    {
        if (!$this->filliers->contains($fillier)) {
            $this->filliers->add($fillier);
            $fillier->setNiveau($this);
        }

        return $this;
    }

    public function removeFillier(Fillier $fillier): self
    {
        if ($this->filliers->removeElement($fillier)) {
            // set the owning side to null (unless already changed)
            if ($fillier->getNiveau() === $this) {
                $fillier->setNiveau(null);
            }
        }

        return $this;
    }
}
