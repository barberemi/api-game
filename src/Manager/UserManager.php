<?php

namespace App\Manager;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UserManager extends AbstractManager
{
    /**
     * CharacteristicManager constructor.
     *
     * @param EntityManagerInterface $em
     * @param SerializerInterface    $serializer
     */
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        parent::__construct($em, $serializer, User::class);
    }

    /**
     * @param array $data
     *
     * @return User
     *
     * @throws \Exception
     */
    public function create(array $data): User
    {
        $exist = $this->em->getRepository(User::class)->findBy(['email' => $data['email']]);

        if ($exist) {
            throw new \Exception('User with this email already exists.');
        }

        $data['plainPassword'] = $data['password'];

        return parent::create($data);
    }
}
