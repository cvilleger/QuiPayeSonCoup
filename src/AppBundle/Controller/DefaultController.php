<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Room;
use AppBundle\Form\RoomType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /* @var Request */
    protected $request;

    /* @var EntityManager */
    protected $em;

    public function preExecute(Request $request){
        $this->request = $request;
        $this->em = $this->getDoctrine()->getManager();
    }

    public function indexAction(){

        return $this->render("AppBundle:Default:index.html.twig");
    }

    public function addAction()
    {
        $form = $this->createForm(new RoomType(), new Room());

        // Handle POST form
        if ($this->request->isMethod('POST')) {
            $form->handleRequest($this->request);
            if ($form->isValid()) {
                /* @var $room Room */
                $room = $form->getData();

                /**
                 * Get users list to add them to the room
                 * */
                $users = $form->get('users')->getData();
                foreach ($users as $user) {
                    $room->addUser($user);
                    $this->em->persist($room);
                }
                /**
                 * Save the object
                 */
                $room->setSlug('salut'); // pour tester, à enlever
                $this->em->persist($room);
                $this->em->flush();
            } else {
                // Error in form
                return $this->redirectToRoute('homepage');
            }
        }

        return $this->render("AppBundle:default:add.html.twig", array(
            'form' => $form->createView()
        ));
    }
}
