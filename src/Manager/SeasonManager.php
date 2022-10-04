<?php

namespace App\Manager;

use App\Entity\Season;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;

class SeasonManager extends AbstractManager
{
    /**
     * SeasonManager constructor.
     *
     * @param EntityManagerInterface $em
     * @param SerializerInterface    $serializer
     */
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        parent::__construct($em, $serializer, Season::class);
    }
}
