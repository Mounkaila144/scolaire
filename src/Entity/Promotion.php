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

    #[ORM\OneToMany(mappedBy: 'promotion', targetEntity: Fillier::class)]
    private Collection $filliers;

    #[ORM\OneToMany(mappedBy: 'promotion', targetEntity: Presence::class)]
    private Collection $presences;

    public function __construct()
    {
        $this->etudiants = new ArrayCollection();
        $this->filliers = new ArrayCollection();
        $this->presences = new ArrayCollection();
    }

    public function __toString(): string
    {
        // TODO: Implement __toString() method.
        $an=$this->annee->format("y");
        return "20$an";
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

    /**
     * @return Collection<int, Presence>
     */
    public function getPresences(): Collection
    {
        return $this->presences;
    }

    public function addPresence(Presence $presence): self
    {
        if (!$this->presences->contains($presence)) {
            $this->presences->add($presence);
            $presence->setPromotion($this);
        }

        return $this;
    }

    public function removePresence(Presence $presence): self
    {
        if ($this->presences->removeElement($presence)) {
            // set the owning side to null (unless already changed)
            if ($presence->getPromotion() === $this) {
                $presence->setPromotion(null);
            }
        }

        return $this;
    }

}
