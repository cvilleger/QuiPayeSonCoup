<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Room;
use AppBundle\Service\RoomService;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use UserBundle\Entity\User;
use UserBundle\Service\UserService;

class DefaultController extends Controller
{
    /* @var Request $request */
    protected $request;

    /* @var EntityManager $em */
    protected $em;

    /* @var UserService $userService */
    protected $userService;

    /* @var RoomService $roomService */
    protected $roomService;

    /* @var User $user */
    protected $user;

    public function preExecute(Request $request){
        $this->request = $request;
        $this->em = $this->getDoctrine()->getManager();
        $this->userService = $this->container->get('UserService');
        $this->roomService = $this->container->get('RoomService');
        $this->user = $this->getUser();
    }

    public function indexAction(){
        if( empty($this->user) ){
            $invitations = $rooms = null;
        }else{
            $invitations = $this->user->getUserInvitations();
            $rooms = $this->user->getRooms();
        }

        return $this->render('AppBundle:Default:index.html.twig', array(
            'invitations'   => $invitations,
            'rooms'         => $rooms
        ));
    }

    /**
     * Ajax with User or Room as subject
     * @return JsonResponse
     */
    public function ajaxAction(){
        if( empty($this->user) ){
            return new JsonResponse();
        }

        $subject = $this->request->get('subject');
        $term = $this->request->get('term');
        $response = array();
        switch($subject){
            case 'user' :
                $users = $this->userService->searchUserByUsername($term);
                /* @var User $user */
                foreach($users as $user){
                    $response[] = $user->getUsername();
                }
                break;
            case 'room' :
                $rooms = $this->roomService->searchRoomByName($term);
                /* @var Room $room */
                foreach($rooms as $room){
                    $response[] = $room->getName();
                }
                break;
        }
        return new JsonResponse($response);
    }

}
