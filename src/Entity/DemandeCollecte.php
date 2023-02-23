<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * DemandeCollecte
 *
 * @ORM\Table(name="demande_collecte", indexes={@ORM\Index(name="id_poubelle", columns={"id_poubelle"}), @ORM\Index(name="id_user", columns={"id_user"})})
 * @ORM\Entity
 */
class DemandeCollecte
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_demande_collecte", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDemandeCollecte;

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
    #[Assert\NotBlank (message:"champs obligatoire")]
    private $etatDemande;

    /**
     * @var \Poubelle
     *
     * @ORM\ManyToOne(targetEntity="Poubelle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_poubelle", referencedColumnName="id_poubelle")
     * })
     */
    #[Assert\NotBlank (message:"champs obligatoire")]
    private $idPoubelle;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    #[Assert\NotBlank (message:"champs obligatoire")]
    private $idUser;

    public function getIdDemandeCollecte(): ?int
    {
        return $this->idDemandeCollecte;
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

    public function getIdPoubelle(): ?Poubelle
    {
        return $this->idPoubelle;
    }

    public function setIdPoubelle(?Poubelle $idPoubelle): self
    {
        $this->idPoubelle = $idPoubelle;

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
    public function __toString() 
    {
        return (string) $this->idDemandeCollecte; 
    }

}
