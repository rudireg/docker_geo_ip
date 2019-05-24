<?php

namespace App\Repository;

use App\Entity\Ips;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Ips|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ips|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ips[]    findAll()
 * @method Ips[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IpsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ips::class);
    }

    /**
     * @return mixed
     */
    public function getIpList()
    {
        $items = $this->findAll();
        $ips = [];
        foreach ($items AS $item) {
            $ips[] = preg_replace('/(.*)(\/.*)/', '$1', $item->getIp());
        };
        return $ips;
    }

    // /**
    //  * @return Ips[] Returns an array of Ips objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ips
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
