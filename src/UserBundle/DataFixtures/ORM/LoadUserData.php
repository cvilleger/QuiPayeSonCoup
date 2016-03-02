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
        $userAdmin->setFirstName('Master');
        $userAdmin->setLastName('Doe');

        $user = new User();
        $user->setUsername('User Test');
        $user->setEmail('user@user.com');
        $user->setPlainPassword('user');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_USER'));
        $user->setFirstName('Citizen');
        $user->setLastName('Dupond');

        $manager->persist($userAdmin);
        $manager->persist($user);
        $manager->flush();

        $this->addReference('userAdmin', $userAdmin);
        $this->addReference('user', $user);
    }

    public function getOrder(){
        return 1;
    }
}
