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


    #[ORM\OneToMany(targetEntity: RendezVous::class, mappedBy: 'projet', orphanRemoval: true)]
    private Collection $rendezVous;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'projets')]
    private Collection $users;

    #[ORM\Column]
    private ?float $paiements = null;

    #[ORM\Column]
    private ?float $resteAPayer = null;

    public function __construct()
    {
        $this->rendezVous = new ArrayCollection();
        $this->users = new ArrayCollection();
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
     * @return Collection<int, RendezVous>
     */
    public function getRendezVous(): Collection
    {
        return $this->rendezVous;
    }

    public function addRendezVous(RendezVous $rendezVous): static
    {
        if (!$this->rendezVous->contains($rendezVous)) {
            $this->rendezVous->add($rendezVous);
            $rendezVous->setProjet($this);
        }

        return $this;
    }

    public function removeRendezVous(RendezVous $rendezVous): static
    {
        if ($this->rendezVous->removeElement($rendezVous)) {
            // set the owning side to null (unless already changed)
            if ($rendezVous->getProjet() === $this) {
                $rendezVous->setProjet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->users;
    }

    public function addUser(User $users): static
    {
        if (!$this->users->contains($users)) {
            $this->users->add($users);
        }

        return $this;
    }

    public function removeUser(User $users): static
    {
        $this->users->removeElement($users);

        return $this;
    }

    public function getPaiements(): ?float
    {
        return $this->paiements;
    }

    public function setPaiements(float $paiements): static
    {
        $this->paiements = $paiements;

        return $this;
    }

    public function getResteAPayer(): ?float
    {
        return $this->resteAPayer;
    }

    public function setResteAPayer(float $resteAPayer): static
    {
        $this->resteAPayer = $resteAPayer;

        return $this;
    }
}
