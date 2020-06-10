<?php

namespace App\Manager;

use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;

class ItemManager extends AbstractManager
{
    /**
     * ItemManager constructor.
     *
     * @param EntityManagerInterface $em
     * @param SerializerInterface    $serializer
     */
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        parent::__construct($em, $serializer, Item::class);
    }
}
