<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Type
 *
 * @ORM\Table(name="type")
 * @ORM\Entity
 */
class Type
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_type", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idType;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_type", type="string", length=255, nullable=false)
     */
    private $nomType;

    /**
     * @var int
     *
     * @ORM\Column(name="poids_vide", type="integer", nullable=false)
     */
    private $poidsVide;

    /**
     * @var string
     *
     * @ORM\Column(name="couleur", type="string", length=255, nullable=false)
     */
    private $couleur;

    public function getIdType(): ?int
    {
        return $this->idType;
    }

    public function getNomType(): ?string
    {
        return $this->nomType;
    }

    public function setNomType(string $nomType): self
    {
        $this->nomType = $nomType;

        return $this;
    }

    public function getPoidsVide(): ?int
    {
        return $this->poidsVide;
    }

    public function setPoidsVide(int $poidsVide): self
    {
        $this->poidsVide = $poidsVide;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }


}
