<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Invitation;

class LoadInvitationData extends AbstractFixture implements OrderedFixtureInterface{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager){
        $invitation1 = new Invitation();
        $invitation1->setUser($this->getReference('user'));
        $invitation1->setRoom($this->getReference('room'));
        $invitation1->setDate(new \DateTime());

        $invitation2 = new Invitation();
        $invitation2->setUser($this->getReference('user2'));
        $invitation2->setRoom($this->getReference('room2'));
        $invitation2->setDate(new \DateTime());

        $manager->persist($invitation1);
        $manager->persist($invitation2);
        $manager->flush();
    }

    public function getOrder(){
        return 2;
    }
}