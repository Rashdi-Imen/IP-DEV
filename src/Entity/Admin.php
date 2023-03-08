<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AdminRepository;


/**
 * Admin
 * @ORM\Entity(repositoryClass="App\Repository\AdminRepository")
 * @ORM\Table(name="admin")
 * @ORM\Entity
 */
class Admin extends User
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }


}
