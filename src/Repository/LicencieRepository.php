<?php

namespace App\Repository;

use App\Entity\Licencie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * @extends ServiceEntityRepository<Licencie>
 *
 * @method Licencie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Licencie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Licencie[]    findAll()
 * @method Licencie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LicencieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Licencie::class);
    }

//    /**
//     * @return Licencie[] Returns an array of Licencie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Licencie
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }



 public function nbLicencie()
 {
     return $this->createQueryBuilder('l')
         ->select('COUNT(l.id)')
         ->getQuery()
         ->getSingleScalarResult();
 }

 /**
     * Récupère les contacts d'une catégorie spécifique.
     *
     * @param int $idCategorie L'ID de la catégorie
     * @return array Les contacts associés à la catégorie
     */
    public function findContactsByCategorie(int $idCategorie): array
    {
        return $this->createQueryBuilder('l')
        ->select('c, l') 
        ->join('l.contact', 'c')
        ->join('l.categorie', 'cat')
        ->andWhere('cat.id = :idCategorie')
        ->setParameter('idCategorie', $idCategorie)
        ->getQuery()
        ->getResult();

    }


    public function getContactsByCategory($categoryId)
{
    $entityManager = $this->getEntityManager();

    $query = $entityManager->createQuery(
        'SELECT contact
        FROM App\Entity\Categorie categorie
        JOIN categorie.licencies licencie
        JOIN licencie.contact contact
        WHERE categorie.id = :categoryId'
    )->setParameter('categoryId', $categoryId);

    return $query->getResult();
}





    
}
