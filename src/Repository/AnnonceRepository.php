<?php

namespace App\Repository;

use App\Entity\Annonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Annonce>
 *
 * @method Annonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonce[]    findAll()
 * @method Annonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }

    public function save(Annonce $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Annonce $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllNotSold(): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.sold = false')
            ->getQuery() // permet de créer un objet utilisable pour récupérer le résultat
            ->getResult() // permet de récupérer le résultat
        ;
    }

    public function findLatestNotSold(): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.sold = false')
            ->getQuery() // permet de créer un objet utilisable pour récupérer le résultat
            ->setMaxResults(3)
            ->getResult() // permet de récupérer le résultat
            ;
    }

    /**
     * @return QueryBuilder
     */
    private function findNotSoldQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.sold = false')
            ;
    }

    /**
     * @return Query
     */
    public function findAllNotSoldQuery()
    {
        return $this->findNotSoldQuery()
            ->getQuery()
            ;
    }


//    /**
//     * @return Annonce[] Returns an array of Annonce objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Annonce
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
