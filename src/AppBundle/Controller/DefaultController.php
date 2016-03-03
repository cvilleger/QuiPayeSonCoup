<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Room;
use AppBundle\Service\RoomService;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;
use UserBundle\Service\UserService;

class DefaultController extends Controller
{
    /* @var Request */
    protected $request;

    /* @var EntityManager */
    protected $em;

    /* @var UserService */
    protected $userService;

    /* @var RoomService */
    protected $roomService;

    public function preExecute(Request $request){
        $this->request = $request;
        $this->em = $this->getDoctrine()->getManager();
        $this->userService = $this->container->get('UserService');
        $this->roomService = $this->container->get('RoomService');
    }

    public function indexAction(){
        return $this->render("AppBundle:Default:index.html.twig");
    }

    /**
     * Ajax with User or Room as subject
     * @return JsonResponse
     */
    public function ajaxAction(){
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
