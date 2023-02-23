<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * DetailsDemande
 *
 * @ORM\Table(name="details_demande", indexes={@ORM\Index(name="id_poubelle", columns={"id_poubelle"}), @ORM\Index(name="id_demande_poubelle", columns={"id_demande_poubelle"})})
 * @ORM\Entity
 */
class DetailsDemande
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_detail_demande", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDetailDemande;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer", nullable=false)
     */
    private $quantite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_demande", type="date", nullable=false)
     */
    private $dateDemande;

    /**
     * @var \DemandePoubelle
     *
     * @ORM\ManyToOne(targetEntity="DemandePoubelle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_demande_poubelle", referencedColumnName="id_demande_poubelle")
     * })
     */
    private $idDemandePoubelle;

    /**
     * @var \Poubelle
     *
     * @ORM\ManyToOne(targetEntity="Poubelle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_poubelle", referencedColumnName="id_poubelle")
     * })
     */
    private $idPoubelle;

    public function getIdDetailDemande(): ?int
    {
        return $this->idDetailDemande;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
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

    public function getIdDemandePoubelle(): ?DemandePoubelle
    {
        return $this->idDemandePoubelle;
    }

    public function setIdDemandePoubelle(?DemandePoubelle $idDemandePoubelle): self
    {
        $this->idDemandePoubelle = $idDemandePoubelle;

        return $this;
    }

    public function getIdPoubelle(): ?Poubelle
    {
        return $this->idPoubelle;
    }

    public function setIdPoubelle(?Poubelle $idPoubelle): self
    {
        $this->idPoubelle = $idPoubelle;

        return $this;
    }


}
