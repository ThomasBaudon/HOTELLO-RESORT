<?php

namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Booking>
 *
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    public function save(Booking $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Booking $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function filters(Booking $booking): array
    {
        // $filters = [];
        //QueryBuilder --> DQL
        $qb = $this->createQueryBuilder('b');


        if ($booking->getStartDate()) {
            $filters['start_date'] = $booking->getStartDate();
            $qb->andWhere('b.start_date = :start_date')->setParameter('start_date', $booking->getStartDate());
        }

        if ($booking->getEndDate()) {
            $filters['end_date'] = $booking->getEndDate();
            $qb->andWhere('b.end_date = :end_date')->setParameter('end_date', $booking->getEndDate());
        }

        if ($booking->getAdultsCap()) {
            $filters['adults_cap'] = $booking->getAdultsCap();
            $qb->andWhere('b.adults_cap = :adults_cap')->setParameter('adults_cap', $booking->getAdultsCap());
        }

        if ($booking->getChildrenCap()) {
            $filters['children_cap'] = $booking->getChildrenCap();
            $qb->andWhere('b.children_cap = :children_cap')->setParameter('children_cap', $booking->getChildrenCap());
        }

        if ($booking->getRoom()) {
            $filters['room_id'] = $booking->getRoom();
            $qb->andWhere('b.room_id = :room_id')->setParameter('room_id', $booking->getRoom());
        }



        return $qb->getQuery()->getResult();


    }

    

}
