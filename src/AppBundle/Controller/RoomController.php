<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Room;
use AppBundle\Form\RoomType;
use AppBundle\Service\RoomService;
use AppBundle\Service\InvitationService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RoomController extends Controller
{
    /** @var  Request $request */
    private $request;

    /** @var  RoomService $roomService */
    private $roomService;

    /** @var  InvitationService invitationService */
    private $invitationService;

    public function preExecute(Request $request){
        $this->request = $request;
        $this->roomService = $this->container->get('RoomService');
        $this->invitationService = $this->container->get('InvitationService');
    }

    /**
     * View a room by slug
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($slug){
        /* @var $room Room */
        $room = $this->roomService->getRoomBySlug($slug);

        if(empty($room)){
            $flashMessage = 'This room does not exist';
            $this->get('session')->getFlashBag()->add('error', $flashMessage);
            return $this->redirectToRoute('homepage');
        }

        if( !$room->getUsers()->contains($this->getUser()) && !$room->getAdministrator() == $this->getUser() ){
            $flashMessage = 'Not authorized to join this room';
            $this->get('session')->getFlashBag()->add('error', $flashMessage);
            return $this->redirectToRoute('homepage');
        }

        return $this->render('AppBundle:Room:view.html.twig', array(
            'room' => $room
        ));
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

            if(empty($room)){
                $flashMessage = 'This room does not exist';
                $this->get('session')->getFlashBag()->add('error', $flashMessage);
                return $this->redirectToRoute('homepage');
            }

            if( !$room->getAdministrator() == $this->getUser() ){
                $flashMessage = 'Not authorized to edit this room';
                $this->get('session')->getFlashBag()->add('error', $flashMessage);
                return $this->redirectToRoute('homepage');
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

    /**
     * Join a specific room
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function joinAction($slug){
        $user = $this->getUser();

        $room = $this->roomService->getRoomBySlug($slug);
        $room->addUser($user);

        $invitation = $this->invitationService->getInvitationByUserAndRoom($user, $room);

        $this->invitationService->remove($invitation);

        $this->roomService->save($room);

        return $this->redirect($this->generateUrl('room_view', array(
            'slug' => $room->getSlug()
        )));
    }
}
