<?php
namespace AppBundle\Tests;

use AppBundle\Service\RoomService;
use Doctrine\Common\DataFixtures\Loader;

class RoomServiceTest extends DoctrineTestCase
{
    /* @var RoomService */
    protected $roomService;

    public function setUp()
    {
        $loader = new Loader();

        echo "\nUser Fixtures \n";
        $loader->loadFromDirectory(__DIR__ . '/../../UserBundle/DataFixtures');

        echo "Room Fixtures \n";
        $loader->loadFromDirectory(__DIR__ . '/../../AppBundle/DataFixtures');

        echo "Execute Fixtures \n";
        $this->executeFixtures($loader);

        $this->roomService = $this->container->get('RoomService');
    }

    function testCountRoom(){
        $rooms = $this->roomService->getRooms();
        $this->assertCount(2, $rooms, 'Should return 2 rooms');
    }

}
