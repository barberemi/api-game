<?php

namespace App\Manager;

use App\Entity\Job;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;

class JobManager extends AbstractManager
{
    /**
     * JobManager constructor.
     *
     * @param EntityManagerInterface $em
     * @param SerializerInterface    $serializer
     */
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        parent::__construct($em, $serializer, Job::class);
    }
}
