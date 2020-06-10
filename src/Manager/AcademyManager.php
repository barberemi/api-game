<?php

namespace App\Manager;

use App\Entity\Academy;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;

class AcademyManager extends AbstractManager
{
    /**
     * AcademyManager constructor.
     *
     * @param EntityManagerInterface $em
     * @param SerializerInterface    $serializer
     */
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        parent::__construct($em, $serializer, Academy::class);
    }
}
