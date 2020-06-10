<?php

namespace App\Manager;

use App\Entity\Monster;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class MonsterManager extends AbstractManager
{
    /**
     * MonsterManager constructor.
     *
     * @param EntityManagerInterface $em
     * @param SerializerInterface    $serializer
     */
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        parent::__construct($em, $serializer, Monster::class);
    }
}
