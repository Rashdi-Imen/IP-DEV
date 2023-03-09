<?php

namespace App\Repository;

use App\Entity\Offre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


/**
 * @extends ServiceEntityRepository<Offre>
 *
 * @method Offre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offre[]    findAll()
 * @method Offre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offre::class);
    }
    
    public function save(Offre $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Offre  $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // Add other custom query methods here
    public function findOffreByName($filtre)
        {
            return $this->createQueryBuilder('o')
                ->where('o.filtre = :filtre')
                ->setParameter('filtre', $filtre)
                ->getQuery()
                ->getResult();
        }

        public function findByCategorieName($nom)
        {
            return $this->createQueryBuilder('o')
                ->join('o.IdCategorie', 'c')
                ->where('c.nom = :nom')
                ->setParameter('nom', $nom)
                ->getQuery()
                ->getResult();
        }

    public function searchNom($nom)
        {
            return $this->createQueryBuilder('s')
                ->andWhere('s.nom LIKE :ncl')
                ->setParameter('ncl', $nom.'%')
                ->getQuery()
                ->execute();
        }

        public function findAll(): array
{
    return $this->createQueryBuilder('o')
        ->getQuery()
        ->getResult();
}
    
}
