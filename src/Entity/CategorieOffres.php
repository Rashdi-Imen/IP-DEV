<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * CategorieOffres
 *
 * @ORM\Table(name="categorie_offres")
 * @ORM\Entity
 */
#[ORM\Entity(repositoryClass: CategorieOffreRepository::class)]
class CategorieOffres
{
    /**
     * @var int
     * @ORM\Column(name="id_categorie", type="integer", nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    #[Groups("categorieOffres")]
    private $idCategorie;

    /**
     * @var string
     * @Assert\NotBlank(message="Le nom de Categorie est obligatoire")
     * @Assert\Length(
     *      min = 2,
     *      max = 20,
     *      minMessage = "Le nom doit comporter au moins {{ limit }} caractères.",
     *      maxMessage = "Le nom ne peut pas comporter plus de {{ limit }} caractères."
     * )
     *  @Assert\Regex(
     *     pattern="/^[A-Z]/",
     *     message="Le premier caractère doit être en majuscule.."
     * )
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    #[Assert\NotNull(message:"La description de Categorie ne peut pas être null")]
    #[Groups("categorieOffres")]
    private $nom;

    /**
     * @var string
     * @Assert\NotBlank(message="La description de Categorie est obligatoire")
     * @Assert\Length(max=500, maxMessage="La description de Categorie ne doit pas dépasser {{ limit }} caractères")
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    #[Groups("categorieOffres")]
    private $description;

    public function getIdCategorie(): ?int
    {
        return $this->idCategorie;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function __toString() 
{
    return (string) $this->nom; 
}

}
