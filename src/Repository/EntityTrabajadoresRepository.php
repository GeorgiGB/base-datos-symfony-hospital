<?php

namespace App\Repository;

use App\Entity\EntityTrabajadores;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EntityTrabajadores>
 *
 * @method EntityTrabajadores|null find($id, $lockMode = null, $lockVersion = null)
 * @method EntityTrabajadores|null findOneBy(array $criteria, array $orderBy = null)
 * @method EntityTrabajadores[]    findAll()
 * @method EntityTrabajadores[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntityTrabajadoresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EntityTrabajadores::class);
    }

    public function save(EntityTrabajadores $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EntityTrabajadores $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return EntityTrabajadores[] Returns an array of EntityTrabajadores objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EntityTrabajadores
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
