<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Room;
use AppBundle\Form\RoomType;
use AppBundle\Service\RoomService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RoomController extends Controller
{
    /** @var  Request $request */
    private $request;

    /** @var  RoomService $roomService */
    private $roomService;

    public function preExecute(Request $request){
        $this->request = $request;
        $this->roomService = $this->container->get('RoomService');
    }

    /**
     * Edit or add a Room
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(){
        $slug = $this->request->get('slug');

        // Add a new Room
        if($slug == false) {
            $room = new Room();
        }
        // Edit a room
        else{
            $room = $this->roomService->getRoomBySlug($slug);

            // No room found by given slug
            if(empty($room)){
                $room = new Room();
            }
        }

        $form = $this->createForm(new RoomType(), $room);
        
        if($this->request->isMethod('POST')){
            $form->handleRequest($this->request);

            if($form->isValid()){
                $room->setAdministrator($this->getUser());
                $this->roomService->save($room);

                return $this->redirect($this->generateUrl('room_view', array(
                    'slug' => $room->getSlug()
                )));
            }
        }

        return $this->render('AppBundle:Room:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
