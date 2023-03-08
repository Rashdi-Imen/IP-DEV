<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;


/**
 * Offre
 *
 * @ORM\Table(name="offre", indexes={@ORM\Index(name="id_categorie", columns={"id_categorie"})})
 * @ORM\Entity
 */
#[ORM\Entity(repositoryClass: OfferRepository::class)]
class Offre
{
    /**
     * @var int
     * @ORM\Column(name="id_offre", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    #[Groups("offres")]
    private $idOffre;

    /**  
     * @var string
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Le nom de l'offre est obligatoire")
     * @Assert\Length(
     *      min = 2,
     *      max = 20,
     *      minMessage = "Le nom doit comporter au moins {{ limit }} caractères.",
     *      maxMessage = "Le nom ne peut pas comporter plus de {{ limit }} caractères."
     * )
     */
     #[Assert\NotNull(message:"L'offre de Categorie ne peut pas être null")]
     #[Assert\NotBlank(message:"Le nom de l'offre est obligatoire")]
     #[Assert\Length(
              min : 2,
              max : 20,
              minMessage : "Le nom doit comporter au moins {{ limit }} caractères.",
              maxMessage : "Le nom ne peut pas comporter plus de {{ limit }} caractères."
         )]
     #[Groups("offres")]
    private $nom;

    /**
     * @var string
     * @Assert\Length(max=500, maxMessage="La description de l'offre ne doit pas dépasser {{ limit }} caractères")
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    #[Assert\NotBlank(message:"La description de l'offre est obligatoire")]
    #[Groups("offres")]
    private $description;

    /**
     * @var string  
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
  //  #[Assert\NotBlank(message:"L'image de l'offre est obligatoire")]
    #[ORM\Column(name:"image", type:"string", length:255, nullable:false)]
    #[Assert\File(mimeTypes:("image/*"), mimeTypesMessage:"Le fichier doit être une image")]
    #[Groups("offres")]
    private $image;

    /**
     * @var string
     * @Assert\NotBlank(message="Le pourcentage est obligatoire")
     * @Assert\Regex(
     *     pattern="/^\d+(\.\d{1,2})?%?$/",
     *     message="La valeur doit être un pourcentage valide."
     * )
     * @ORM\Column(name="points", type="string", length=4, nullable=false)
     */
    #[Groups("offres")]
    private $points;

    /**
     * @var \CategorieOffres
     * @ORM\ManyToOne(targetEntity="CategorieOffres",cascade={"persist"}))
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="id_categorie", referencedColumnName="id_categorie")
     * })
     */
    #[ORM\ManyToOne(targetEntity:"CategorieOffres", cascade:"persist")]
    #[Groups("offres")]
    private $idCategorie;

    public function getIdOffre(): ?int
    {
        return $this->idOffre;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPoints(): ?string
    {
        return $this->points;
    }

    public function setPoints(string $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getIdCategorie(): ?CategorieOffres
    {
        return $this->idCategorie;
    }

    public function setIdCategorie(?CategorieOffres $idCategorie): self
    {
        $this->idCategorie = $idCategorie;

        return $this;
    }

    public function __toString() 
    {
        return (string) $this->nom; 
    }


}
