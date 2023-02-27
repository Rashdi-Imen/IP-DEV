<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * FicheCollecte
 *
 * @ORM\Table(name="fiche_collecte", indexes={@ORM\Index(name="id_demande_collecte", columns={"id_demande_collecte"}), @ORM\Index(name="id_user", columns={"id_user"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\FichesRepository")
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
    #[Groups("Fiches")]
    private $idFicheCollecte;

    /**
     * @var int
     *
     * @ORM\Column(name="poids", type="integer", nullable=false)
     */
    #[Assert\NotBlank (message:"champs obligatoire")]
    #[Groups("Fiches")]
    #[Assert\Positive (message:"le poids doit etre positive")]
    public $poids;

    /**
     * @var \DemandeCollecte
     *
     * @ORM\ManyToOne(targetEntity="DemandeCollecte")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_demande_collecte", referencedColumnName="id_demande_collecte")
     * })
     */
    #[Assert\NotBlank (message:"champs obligatoire")]
    #[Groups("Fiches")]
    private $idDemandeCollecte;

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
