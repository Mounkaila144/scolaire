<?php

namespace App\Repository;

use App\Entity\Fillier;
use App\Entity\Promotion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fillier>
 *
 * @method Fillier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fillier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fillier[]    findAll()
 * @method Fillier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FillierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fillier::class);
    }

    public function add(Fillier $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Fillier $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Fillier[] Returns an array of Fillier objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }
    public function findByPromotion( $promotion)
    {
            return $this->createQueryBuilder('f')
                ->where('f.promotion=:val')
                ->setParameter('val', $promotion)
                ->getQuery()
                ->getResult();

    }

    public function findByNiveau($value, $promotion)
    {

            return $this->createQueryBuilder('f')
                ->andwhere('f.niveau=:val')
                ->andwhere('f.promotion=:pro')
                ->join('f.etudiants', 'e')
                ->select('COUNT(e.id)')
                ->setParameter('val', $value)
                ->setParameter('pro', $promotion)
                ->getQuery()
                ->getSingleScalarResult();

    }
}
