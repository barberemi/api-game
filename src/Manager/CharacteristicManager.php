<?php

namespace App\Manager;

use App\Entity\Characteristic;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;

class CharacteristicManager extends AbstractManager
{
    /**
     * CharacteristicManager constructor.
     *
     * @param EntityManagerInterface $em
     * @param SerializerInterface    $serializer
     */
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        parent::__construct($em, $serializer, Characteristic::class);
    }
}
