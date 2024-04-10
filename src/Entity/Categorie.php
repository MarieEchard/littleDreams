<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomCategorie = null;

    #[ORM\OneToMany(targetEntity: Projet::class, mappedBy: 'categorie', orphanRemoval: true)]
    private Collection $projets;

    #[ORM\ManyToMany(targetEntity: ItemPortfolio::class, mappedBy: 'categories')]
    private Collection $itemPortfolios;

    public function __construct()
    {
        $this->projets = new ArrayCollection();
        $this->itemPortfolios = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCategorie(): ?string
    {
        return $this->nomCategorie;
    }

    public function setNomCategorie(string $nomCategorie): static
    {
        $this->nomCategorie = $nomCategorie;

        return $this;
    }

    /**
     * @return Collection<int, Projet>
     */
    public function getProjets(): Collection
    {
        return $this->projets;
    }

    public function addProjet(Projet $projet): static
    {
        if (!$this->projets->contains($projet)) {
            $this->projets->add($projet);
            $projet->setCategorie($this);
        }

        return $this;
    }

    public function removeProjet(Projet $projet): static
    {
        if ($this->projets->removeElement($projet)) {
            // set the owning side to null (unless already changed)
            if ($projet->getCategorie() === $this) {
                $projet->setCategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ItemPortfolio>
     */
    public function getItemPortfolios(): Collection
    {
        return $this->itemPortfolios;
    }

    public function addItemPortfolio(ItemPortfolio $itemPortfolio): static
    {
        if (!$this->itemPortfolios->contains($itemPortfolio)) {
            $this->itemPortfolios->add($itemPortfolio);
            $itemPortfolio->addCategory($this);
        }

        return $this;
    }

    public function removeItemPortfolio(ItemPortfolio $itemPortfolio): static
    {
        if ($this->itemPortfolios->removeElement($itemPortfolio)) {
            $itemPortfolio->removeCategory($this);
        }

        return $this;
    }
}
