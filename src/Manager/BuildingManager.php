<?php

namespace App\Manager;

use App\Entity\Building;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;

class BuildingManager extends AbstractManager
{
    /**
     * BuildingManager constructor.
     *
     * @param EntityManagerInterface $em
     * @param SerializerInterface    $serializer
     */
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        parent::__construct($em, $serializer, Building::class);
    }
}
