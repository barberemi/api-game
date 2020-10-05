<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MessageRepository extends AbstractRepository
{
    /**
     * MessageRepository constructor.
     *
     * @param ManagerRegistry    $registry
     * @param ValidatorInterface $validator
     */
    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator)
    {
        parent::__construct($registry, Message::class, $validator);
    }
}
