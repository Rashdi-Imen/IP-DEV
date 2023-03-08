<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\InheritanceType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[InheritanceType('JOINED')] //heritage dans table user
#[DiscriminatorColumn(name:'Type',type:'string')]//ajouter une colonne dans la bd avec le nom type et dont le type de la colonne est String
#[DiscriminatorMap(['admin'=>Admin::class,'citoyen'=>Citoyen::class])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
/**
 * User
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"user" = "User", "citoyen" = "Citoyen", "admin" = "Admin"})
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_8D93D649E7927C74", columns={"email"})})
 * @ORM\Entity
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private ?int $id = null;

      /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    #[ORM\Column(length: 180, unique: true)]//email unique
    private ?string $email = null; 

    #[ORM\Column]//role=admin,user,...
     /**
     * @ORM\Column(name="roles", nullable=false)
     */
    private array $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    #[ORM\Column]
    private ?string $password = null;
    /**
     * @var string The hashed password
     * @ORM\Column(name="confirm_password", type="string", length=255, nullable=false)
     */
    #[ORM\Column]
    private ?string $confirm_password = null;

    /**
     * @var string The hashed password
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    #[ORM\Column(length: 255)]
    private ?string $nom = null;

     /**
     * @var string The hashed password
     * @ORM\Column(name="prenom", type="string", length=255, nullable=false)
     */
    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    /**
     * @var string The hashed password
     * @ORM\Column(name="tel", type="string", length=255, nullable=false)
     */
    #[ORM\Column(length: 255)]
    private ?string $tel = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
    public function getConfirmPassword(): ?string
    {
        return $this->confirm_password;
    }

    public function setConfirmPassword(string $confirm_password): self
    {
        $this->confirm_password = $confirm_password;

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
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return  $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        
    }

    public function setRoles(array $roles): self
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

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }
}
