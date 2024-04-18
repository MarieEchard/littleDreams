<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: "Un compte existe déjà avec cet email.")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\Email( message: 'L\'email {{ value }} n\'est pas un email valide il doit être de forme: "JohnSmith@exemple.com".')]
    #[Assert\NotBlank(message: "Ce champ ne peut pas être vide.")]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = ["ROLE_USER"];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private string $password;

    #[ORM\Column(length: 50, nullable: false)]
    #[Assert\Length(min: 3, minMessage: "La longueur doit être au moins de {{ limit }} caractères.")]
    #[Assert\NotBlank(message: "Ce champ ne peut pas être vide.")]
    private ?string $nom = null;

    #[ORM\Column(length: 50, nullable: false)]
    #[Assert\Length(min: 3, minMessage: "La longueur doit être au moins de {{ limit }} caractères.")]
    #[Assert\NotBlank(message: "Ce champ ne peut pas être vide.")]
    private ?string $prenom = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Veuillez saisir le nom de votre société')]
    private ?string $nomSociete = null;

    #[ORM\Column(length: 10)]
    #[Assert\NotBlank(message: 'Veuillez saisir le numero de rue de votre adresse de facturation')]
    private ?string $noRue = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Veuillez saisir le nom de rue de votre adresse de facturation')]
    private ?string $rue = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: 'Veuillez saisir le code postal de votre adresse de facturation')]
    private ?string $codePostal = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Veuillez saisir le nom de ville de votre adresse de facturation')]
    private ?string $ville = null;

    #[ORM\OneToMany(targetEntity: Question::class, mappedBy: 'user', orphanRemoval: true)]
    #[ORM\JoinColumn(nullable: true)]
    private Collection $questions;

    #[ORM\OneToMany(targetEntity: RendezVous::class, mappedBy: 'user', orphanRemoval: true)]
    #[ORM\JoinColumn(nullable: true)]
    private Collection $rendezVous;

    #[ORM\ManyToMany(targetEntity: Projet::class, inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: true)]
    private Collection $projets;

    #[ORM\Column(length: 255)]
    private ?string $noSiret = null;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->rendezVous = new ArrayCollection();
        $this->projets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // garantit que tous les utilisateurs aient le ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getNomSociete(): ?string
    {
        return $this->nomSociete;
    }

    public function setNomSociete(string $nomSociete): static
    {
        $this->nomSociete = $nomSociete;

        return $this;
    }

    public function getNoRue(): ?string
    {
        return $this->noRue;
    }

    public function setNoRue(string $noRue): static
    {
        $this->noRue = $noRue;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): static
    {
        $this->rue = $rue;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): static
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): static
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setUser($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): static
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getUser() === $this) {
                $question->setUser(null);
            }
        }

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
            $rendezVou->setUser($this);
        }

        return $this;
    }

    public function removeRendezVou(RendezVous $rendezVou): static
    {
        if ($this->rendezVous->removeElement($rendezVou)) {
            // set the owning side to null (unless already changed)
            if ($rendezVou->getUser() === $this) {
                $rendezVou->setUser(null);
            }
        }

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
            $projet->addUser($this);
        }

        return $this;
    }

    public function removeProjet(Projet $projet): static
    {
        if ($this->projets->removeElement($projet)) {
            $projet->removeUser($this);
        }

        return $this;
    }

    public function getNoSiret(): ?string
    {
        return $this->noSiret;
    }

    public function setNoSiret(string $noSiret): static
    {
        $this->noSiret = $noSiret;

        return $this;
    }
}
