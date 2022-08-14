<?php

namespace App\Entity;

use App\Repository\EtudiantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtudiantRepository::class)]
class Etudiant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column]
    private ?int $numero = null;

    #[ORM\Column(length: 255)]
    private ?string $telephone = null;

    #[ORM\Column]
    private ?int $scolariter_payer = null;

    #[ORM\Column]
    private ?bool $inscription_payer = null;

    #[ORM\ManyToOne(inversedBy: 'etudiants')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Fillier $fillier = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getScolariterPayer(): ?int
    {
        return $this->scolariter_payer;
    }

    public function setScolariterPayer(int $scolariter_payer): self
    {
        $this->scolariter_payer = $scolariter_payer;

        return $this;
    }

    public function isInscriptionPayer(): ?bool
    {
        return $this->inscription_payer;
    }

    public function setInscriptionPayer(bool $inscription_payer): self
    {
        $this->inscription_payer = $inscription_payer;

        return $this;
    }

    public function getFillier(): ?Fillier
    {
        return $this->fillier;
    }

    public function setFillier(?Fillier $fillier): self
    {
        $this->fillier = $fillier;

        return $this;
    }
}
