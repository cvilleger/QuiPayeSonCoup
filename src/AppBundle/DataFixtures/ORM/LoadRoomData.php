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
        $room->setName('After Work ESGI');
        $room->setSlug('after-work-esgi');
        $room->setIsActivated(true);
        $room->setDateStart(new \DateTime());
        $room->addUser($this->getReference('userAdmin'));

        $room2 = new Room();
        $room2->setAdministrator($this->getReference('userAdmin'));
        $room2->setName('Happy New Year');
        $room2->setSlug('happy-new-year');
        $room2->setIsActivated(true);
        $room2->setDateStart(new \DateTime());
        $room->addUser($this->getReference('user'));

        $manager->persist($room);
        $manager->persist($room2);
        $manager->flush();

        $this->addReference('roomAdmin', $room);
        $this->addReference('room', $room2);
    }

    public function getOrder(){
        return 2;
    }
}

