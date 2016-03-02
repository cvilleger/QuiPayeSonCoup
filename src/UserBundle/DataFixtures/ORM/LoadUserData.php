<?php

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UserBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager){
        $userAdmin = new User();
        $userAdmin->setUsername('Admin Test');
        $userAdmin->setEmail('admin.test@admin.com');
        $userAdmin->setPlainPassword('admin');
        $userAdmin->setEnabled(true);
        $userAdmin->setRoles(array('ROLE_ADMIN'));

        $user = new User();
        $user->setUsername('User');
        $user->setEmail('user@user.com');
        $user->setPlainPassword('user');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_USER'));

        $manager->persist($userAdmin);
        $manager->persist($user);
        $manager->flush();

        $this->addReference('user', $userAdmin);
        $this->addReference('user2', $user);
    }

    public function getOrder(){
        return 1;
    }
}