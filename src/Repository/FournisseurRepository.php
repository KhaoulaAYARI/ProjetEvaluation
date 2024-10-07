<?php
//ok avec syllabus 07-10-24

namespace App\Repository;

use App\Entity\Fournisseur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fournisseur>
 */
class FournisseurRepository extends ServiceEntityRepository
{
    //private ManagerRegistry $doctrine;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fournisseur::class);
    }
        //rechercher par filtres
        public function fournisseurFiltre ($filtres){
            $em = $this->getEntityManager();
            $query = $em->createQuery(
                    'SELECT l.nom, l.email, l.adresse FROM App\Entity\Fournisseur l WHERE l.nom LIKE UPPER(:nom)');
                    $query->setParameter('nom', '%' . mb_strtoupper($filtres['nom']) .'%');

            $res = $query->getResult();
            return $res;
        }
    
    

   
    

        
    

    //    /**
    //     * @return Fournisseur[] Returns an array of Fournisseur objects
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

    //    public function findOneBySomeField($value): ?Fournisseur
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
