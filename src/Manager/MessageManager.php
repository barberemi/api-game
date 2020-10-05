<?php

namespace App\Manager;

use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;

class MessageManager extends AbstractManager
{
    /**
     * MessageManager constructor.
     *
     * @param EntityManagerInterface $em
     * @param SerializerInterface    $serializer
     */
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        parent::__construct($em, $serializer, Message::class);
    }
}
