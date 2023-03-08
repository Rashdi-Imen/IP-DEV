<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CitoyenRepository;

/**
 * Citoyen
 * @ORM\Entity(repositoryClass="App\Repository\CitoyenRepository")
 * @ORM\Table(name="citoyen")
 * @ORM\Entity
 */
class Citoyen extends User
{
    /**
     * @var int
     * 
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=false)
     */
    private $adresse;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }


}
