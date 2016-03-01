<?php
namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Repository\RepositoryFactory;
use AppBundle\Entity\Invitation;

class InvitationService {

    /* @var EntityManager $em */
    protected $em;

    /* @var RepositoryFactory  $invitationRepository*/
    protected $invitationRepository;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager){
        $this->em = $entityManager;
        $this->invitationRepository = $this->em->getRepository('AppBundle:Invitation');
    }

    /**
     * Remove an Invitation from database
     * @param Invitation $invitation
     */
    public function remove(Invitation $invitation){
        $this->em->remove($invitation);
        $this->em->flush($invitation);
    }

    /**
     * Save an Invitation in database
     * @param Invitation $invitation
     */
    public function save(Invitation $invitation){
        $this->em->persist($invitation);
        $this->em->flush($invitation);
    }
}
