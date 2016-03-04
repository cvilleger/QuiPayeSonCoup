<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;

class MailService
{
    /* @var EntityManager $em */
    protected $em;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager){
        $this->em = $entityManager;
    }

    /**
     * Send mail
     * @param $subject
     * @param $from
     * @param $to
     * @param $body
     */
    public function send($subject, $from, $to, $body){
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($body);
        $this->get('mailer')->send($message);
    }
}
