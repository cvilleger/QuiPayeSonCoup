<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Room;

class LoadRoomData extends AbstractFixture implements OrderedFixtureInterface{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager){
        $room = new Room();
        $room->setAdministrator($this->getReference('user'));
        $room->setName('Ecole');
        $room->setSlug('ecole');
        $room->setIsActivated(true);
        $room->setDateStart(new \DateTime());

        $room2 = new Room();
        $room2->setAdministrator($this->getReference('user2'));
        $room2->setName('Travail');
        $room2->setSlug('travail');
        $room2->setIsActivated(true);
        $room2->setDateStart(new \DateTime());

        $manager->persist($room);
        $manager->persist($room2);
        $manager->flush();

        $this->addReference('room', $room);
        $this->addReference('room2', $room2);
    }

    public function getOrder(){
        return 1;
    }
}
