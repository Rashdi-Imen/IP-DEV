<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FicheCollecte
 *
 * @ORM\Table(name="fiche_collecte", indexes={@ORM\Index(name="id_user", columns={"id_user"}), @ORM\Index(name="id_demande_collecte", columns={"id_demande_collecte"})})
 * @ORM\Entity
 */
class FicheCollecte
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_fiche_collecte", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFicheCollecte;

    /**
     * @var int
     *
     * @ORM\Column(name="poids", type="integer", nullable=false)
     */
    private $poids;

    /**
     * @var \DemandeCollecte
     *
     * @ORM\ManyToOne(targetEntity="DemandeCollecte")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_demande_collecte", referencedColumnName="id_demande_collecte")
     * })
     */
    private $idDemandeCollecte;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    public function getIdFicheCollecte(): ?int
    {
        return $this->idFicheCollecte;
    }

    public function getPoids(): ?int
    {
        return $this->poids;
    }

    public function setPoids(int $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    public function getIdDemandeCollecte(): ?DemandeCollecte
    {
        return $this->idDemandeCollecte;
    }

    public function setIdDemandeCollecte(?DemandeCollecte $idDemandeCollecte): self
    {
        $this->idDemandeCollecte = $idDemandeCollecte;

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
