<?php

namespace App\Entity;

use App\Repository\PromotionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromotionRepository::class)]
class Promotion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $annee = null;

    #[ORM\OneToMany(mappedBy: 'promotion', targetEntity: Etudiant::class)]
    private Collection $etudiants;

    #[ORM\OneToMany(mappedBy: 'promotion', targetEntity: Fillier::class)]
    private Collection $filliers;

    public function __construct()
    {
        $this->etudiants = new ArrayCollection();
        $this->filliers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnnee(): ?\DateTimeInterface
    {
        return $this->annee;
    }

    public function setAnnee(\DateTimeInterface $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * @return Collection<int, Etudiant>
     */
    public function getEtudiants(): Collection
    {
        return $this->etudiants;
    }

    public function addEtudiant(Etudiant $etudiant): self
    {
        if (!$this->etudiants->contains($etudiant)) {
            $this->etudiants->add($etudiant);
            $etudiant->setPromotion($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): self
    {
        if ($this->etudiants->removeElement($etudiant)) {
            // set the owning side to null (unless already changed)
            if ($etudiant->getPromotion() === $this) {
                $etudiant->setPromotion(null);
            }
        }

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
            $fillier->setPromotion($this);
        }

        return $this;
    }

    public function removeFillier(Fillier $fillier): self
    {
        if ($this->filliers->removeElement($fillier)) {
            // set the owning side to null (unless already changed)
            if ($fillier->getPromotion() === $this) {
                $fillier->setPromotion(null);
            }
        }

        return $this;
    }

}
