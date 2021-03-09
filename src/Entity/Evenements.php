<?php

namespace App\Entity;

use App\Repository\EvenementsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvenementsRepository::class)
 */
class Evenements
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
    private $img;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre_evenements;

    /**
     * @ORM\Column(type="date")
     */
    private $date_evenements;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $lieux;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $reservation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $max_personne;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $horaire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $age_cible;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    public function getTitreEvenements(): ?string
    {
        return $this->titre_evenements;
    }

    public function setTitreEvenements(string $titre_evenements): self
    {
        $this->titre_evenements = $titre_evenements;

        return $this;
    }

    public function getDateEvenements(): ?\DateTimeInterface
    {
        return $this->date_evenements;
    }

    public function setDateEvenements(\DateTimeInterface $date_evenements): self
    {
        $this->date_evenements = $date_evenements;

        return $this;
    }

    public function getLieux(): ?string
    {
        return $this->lieux;
    }

    public function setLieux(?string $lieux): self
    {
        $this->lieux = $lieux;

        return $this;
    }

    public function getReservation(): ?string
    {
        return $this->reservation;
    }

    public function setReservation(string $reservation): self
    {
        $this->reservation = $reservation;

        return $this;
    }

    public function getMaxPersonne(): ?int
    {
        return $this->max_personne;
    }

    public function setMaxPersonne(?int $max_personne): self
    {
        $this->max_personne = $max_personne;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(?int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getHoraire(): ?string
    {
        return $this->horaire;
    }

    public function setHoraire(?string $horaire): self
    {
        $this->horaire = $horaire;

        return $this;
    }

    public function getAgeCible(): ?string
    {
        return $this->age_cible;
    }

    public function setAgeCible(string $age_cible): self
    {
        $this->age_cible = $age_cible;

        return $this;
    }
}
