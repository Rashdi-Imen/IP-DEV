<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Poubelle
 *
 * @ORM\Table(name="poubelle", indexes={@ORM\Index(name="id_type", columns={"id_type"}), @ORM\Index(name="id_user", columns={"id_user"})})
 * @ORM\Entity
 */
class Poubelle
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_poubelle", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPoubelle;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    /**
     * @var \Type
     *
     * @ORM\ManyToOne(targetEntity="Type")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_type", referencedColumnName="id_type")
     * })
     */
    private $idType;

    public function getIdPoubelle(): ?int
    {
        return $this->idPoubelle;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getIdType(): ?Type
    {
        return $this->idType;
    }

    public function setIdType(?Type $idType): self
    {
        $this->idType = $idType;

        return $this;
    }

    public function __toString() 
    {
        return (string) $this->idPoubelle; 
    }
}
