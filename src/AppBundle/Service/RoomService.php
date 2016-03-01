<?php
namespace AppBundle\Service;

use AppBundle\Entity\Room;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Repository\RepositoryFactory;
use UserBundle\Entity\User;

class RoomService {

    /* @var EntityManager */
    protected $em;

    /* @var RepositoryFactory */
    protected $roomRepository;

    /**
     * @param EntityManager $entityManager
     */
    function __construct(EntityManager $entityManager){
        $this->em = $entityManager;
        $this->roomRepository = $this->em->getRepository('AppBundle:Room');
    }

    /**
     * Search for a room through name
     * Return an array of room
     * @param String $term
     * @return array
     */
    function searchRoomByName($term){
        return $this->roomRepository->createQueryBuilder('r')
            ->where('r.name LIKE :term')
            ->setParameter('term', '%'.$term.'%')
            ->getQuery()
            ->getResult();
    }

    /**
     * Remove a room from database
     * @param Room $room
     */
    function remove(Room $room){
        $this->em->remove($room);
        $this->em->flush($room);
    }

    /**
     * Save a room into database
     * @param Room $room
     */
    function save(Room $room){
        $this->em->persist($room);
        $this->em->flush($room);
    }


}
