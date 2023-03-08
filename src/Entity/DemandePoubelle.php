<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * DemandePoubelle
 *
 * @ORM\Table(name="demande_poubelle", indexes={@ORM\Index(name="id_user", columns={"id_user"})})
 * @ORM\Entity
 */
class DemandePoubelle
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_demande_poubelle", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDemandePoubelle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_demande", type="date", nullable=false)
     */
    private $dateDemande;

    /**
     * @var string
     *
     * @ORM\Column(name="etat_demande", type="string", length=255, nullable=false)
     */
    private $etatDemande;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idUser;

    public function getIdDemandePoubelle(): ?int
    {
        return $this->idDemandePoubelle;
    }

    public function getDateDemande(): ?\DateTimeInterface
    {
        return $this->dateDemande;
    }

    public function setDateDemande(\DateTimeInterface $dateDemande): self
    {
        $this->dateDemande = $dateDemande;

        return $this;
    }

    public function getEtatDemande(): ?string
    {
        return $this->etatDemande;
    }

    public function setEtatDemande(string $etatDemande): self
    {
        $this->etatDemande = $etatDemande;

        return $this;
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


}
