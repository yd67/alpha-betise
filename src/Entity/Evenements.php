<?php

namespace App\Entity;

use App\Repository\EvenementsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private $title;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $lieux;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $reservation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $max_personne;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $age_cible;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start;

    /**
     * @ORM\Column(type="datetime")
     */
    private $end;

    /**
     * @ORM\Column(type="string", length=7, nullable=true)
     */
    private $background_color;

    /**
     * @ORM\Column(type="string", length=7, nullable=true)
     */
    private $text_color;

    /**
     * @ORM\OneToMany(targetEntity=EventsParticipant::class, mappedBy="evenement")
     */
    private $eventsParticipants;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    public function __construct()
    {
        $this->eventsParticipants = new ArrayCollection();
    }

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getAgeCible(): ?string
    {
        return $this->age_cible;
    }

    public function setAgeCible(string $age_cible): self
    {
        $this->age_cible = $age_cible;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getBackgroundColor(): ?string
    {
        return $this->background_color;
    }

    public function setBackgroundColor(?string $background_color): self
    {
        $this->background_color = $background_color;

        return $this;
    }

    public function getTextColor(): ?string
    {
        return $this->text_color;
    }

    public function setTextColor(?string $text_color): self
    {
        $this->text_color = $text_color;

        return $this;
    }

    /**
     * @return Collection|EventsParticipant[]
     */
    public function getEventsParticipants(): Collection
    {
        return $this->eventsParticipants;
    }

    public function addEventsParticipant(EventsParticipant $eventsParticipant): self
    {
        if (!$this->eventsParticipants->contains($eventsParticipant)) {
            $this->eventsParticipants[] = $eventsParticipant;
            $eventsParticipant->setEvenement($this);
        }

        return $this;
    }

    public function removeEventsParticipant(EventsParticipant $eventsParticipant): self
    {
        if ($this->eventsParticipants->removeElement($eventsParticipant)) {
            // set the owning side to null (unless already changed)
            if ($eventsParticipant->getEvenement() === $this) {
                $eventsParticipant->setEvenement(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

}
