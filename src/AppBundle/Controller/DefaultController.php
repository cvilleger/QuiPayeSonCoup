<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\RoomType;
use AppBundle\Entity\Room;

class DefaultController extends Controller
{

    public function addAction(Request $request)
    {
        $room = new Room();
        $form = $this->createForm(new RoomType(), $room);

        $form->handleRequest($request);
        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            /**
             * Get users list to add them to the room
             * */
            $users = $form->get('users')->getData();
            foreach($users as $user) {
                echo $user->getUsername();
                $room->addUser($user);
                $em->persist($room);
            }
            /**
             * Save the object
             */
            $room->setSlug('salut'); // pour tester, à enlever
            $em->persist($room);
            $em->flush();
        }

        return $this->render("AppBundle:default:addRoom.html.twig", array(
            'form' => $form->createView()
        ));
    }
}
