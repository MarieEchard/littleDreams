<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjetRepository::class)]
class Projet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $budget = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(length: 255)]
    private ?string $details = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $documents = null;

    #[ORM\ManyToOne(inversedBy: 'projets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'projets')]
    private Collection $user;

    #[ORM\OneToMany(targetEntity: RendezVous::class, mappedBy: 'projet', orphanRemoval: true)]
    private Collection $rendezVous;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->rendezVous = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBudget(): ?float
    {
        return $this->budget;
    }

    public function setBudget(float $budget): static
    {
        $this->budget = $budget;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(string $details): static
    {
        $this->details = $details;

        return $this;
    }

    public function getDocuments(): ?string
    {
        return $this->documents;
    }

    public function setDocuments(?string $documents): static
    {
        $this->documents = $documents;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        $this->user->removeElement($user);

        return $this;
    }

    /**
     * @return Collection<int, RendezVous>
     */
    public function getRendezVous(): Collection
    {
        return $this->rendezVous;
    }

    public function addRendezVou(RendezVous $rendezVou): static
    {
        if (!$this->rendezVous->contains($rendezVou)) {
            $this->rendezVous->add($rendezVou);
            $rendezVou->setProjet($this);
        }

        return $this;
    }

    public function removeRendezVou(RendezVous $rendezVou): static
    {
        if ($this->rendezVous->removeElement($rendezVou)) {
            // set the owning side to null (unless already changed)
            if ($rendezVou->getProjet() === $this) {
                $rendezVou->setProjet(null);
            }
        }

        return $this;
    }
}
