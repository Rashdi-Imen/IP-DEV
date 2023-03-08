<?php

namespace App\Repository;


use App\Entity\CategorieOffres;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


/**
 * @extends ServiceEntityRepository<CategorieOffres>
 *
 * @method CategorieOffres|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieOffres|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieOffres[]    findAll()
 * @method CategorieOffres[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieOffreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieOffres::class);
    }
    
    public function save(CategorieOffres $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CategorieOffres  $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // Add other custom query methods here
}