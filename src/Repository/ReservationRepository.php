<?php

namespace App\Repository;

use App\Entity\Admin\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    // /**
    //  * @return Reservation[] Returns an array of Reservation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reservation
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
//LEFT JOIN WITH SQL
    public function showReservation($id): array {

        $conn=$this->getEntityManager()->getConnection();
        $sql='
       SELECT rz.*,c.title as cname,v.title as vname
FROM reservation rz
        JOIN cars c on c.id = rz.carsid
        JOIN vehicles v on v.id = rz.vehicleid
        WHERE rz.id = :id
       ';
        $stmt=$conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        // returns an array of arrays
        return $stmt->fetchAll();

    }
    public function getUserReservation($id): array {

        $conn=$this->getEntityManager()->getConnection();
        $sql='
        SELECT v.*,c.title as carsname, u.name, as rname FROM reservation v 
        JOIN cars ca on ca.id = v.carsid
        JOIN vehicles u on u.id = v.vehiclesid
        WHERE v.vehiclesid=:id
        ORDER BY v.title DESC
       ';
        $stmt=$conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        // returns an array of arrays
        return $stmt->fetchAll();

    }

    // ** ** LEFT JOIN WITH SQL **********

    public function getReservation($id):array
    {
        $conn =$this->getEntityManager()->getConnection();

        $sql = '
           SELECT rz.*,c.title as cname,v.title as vname, usr.name as username 
FROM reservation rz 
           JOIN cars c ON c.id = rz.carsid
           JOIN vehicles v ON v.id = rz.vehicleid
           JOIN user usr ON usr.id = rz.userid
           WHERE rz.userid = :id
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        //returns an array of arrays (i.e raw data set)
        return $stmt->fetchAll();
    }


    // ** ** LEFT JOIN WITH SQL **********

    public function getReservations($status):array
    {
        $conn =$this->getEntityManager()->getConnection();

        $sql = '
           SELECT v.*,c.title as cname,u.title as rname, usr.name as username FROM reservation r 
           JOIN cars ca ON c.id = v.carsid
           JOIN vehicle u ON u.id = r.vehicleid
           JOIN user usr ON usr.id = r.userid
           WHERE v.status = :status
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['status' => $status]);

        //returns an array of arrays (i.e raw data set)
        return $stmt->fetchAll();
    }

}
