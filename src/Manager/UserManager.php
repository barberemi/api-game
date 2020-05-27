<?php

namespace App\Manager;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserManager
{
    /**
     * @var EntityManagerInterface $em
     */
    protected $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $email
     * @param string $plainPassword
     *
     * @return User
     *
     * @throws \Exception
     */
    public function create(string $email, string $plainPassword): User
    {
        $exist = $this->em->getRepository(User::class)->findBy(['email' => $email]);

        if ($exist) {
            throw new \Exception('User with this email already exists.');
        }

        try {
            $user = $this->em->getRepository(User::class)->create($email, $plainPassword);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $user;
    }
}
