<?php

use AppBundle\Entity\Room;
use AppBundle\Service\RoomService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use UserBundle\Entity\User;

class RoomServiceTest extends WebTestCase
{
    /* @var RoomService */
    protected static $roomService;

    public static function setUpBeforeClass()
    {
        //start the symfony kernel
        $kernel = static::createKernel();
        $kernel->boot();

        //get the container
        $container = $kernel->getContainer();

        self::$roomService = $container->get('RoomService');
    }

    function testRoomSave(){
        $user1 = new User();
        $user1->setUsername('test1Username');
        $user1->setEmail('test1Email');
        $user1->setPlainPassword('test1PlainPassword');
        $user1->setEnabled(true);
        $user1->setRoles(array('ROLE_USER'));
        $user1->setFirstName('test1FirstName');
        $user1->setLastName('test1LastName');

        $user2 = new User();
        $user2->setUsername('test2Username');
        $user2->setEmail('test2Email');
        $user2->setPlainPassword('test2PlainPassword');
        $user2->setEnabled(true);
        $user2->setRoles(array('ROLE_USER'));
        $user2->setFirstName('test2FirstName');
        $user2->setLastName('test2LastName');

        $room = new Room();
        $room->setAdministrator($user1);
        $room->setName('testName');
        $slug = 'testSlug';
        $room->setSlug($slug);
        $room->setIsActivated(true);
        $room->setDateStart(new \DateTime());
        $room->addUser($user2);

        self::$roomService->save($room);

        $roomFromDb = self::$roomService->getRoomBySlug($slug);

        $this->assertEquals($room, $roomFromDb);
    }




}