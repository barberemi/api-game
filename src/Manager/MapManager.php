<?php

namespace App\Manager;

use App\Entity\Map;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;

class MapManager extends AbstractManager
{
    /**
     * MapManager constructor.
     *
     * @param EntityManagerInterface $em
     * @param SerializerInterface    $serializer
     */
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        parent::__construct($em, $serializer, Map::class);
    }
}
