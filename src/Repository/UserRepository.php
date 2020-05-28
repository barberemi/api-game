<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserRepository extends AbstractRepository
{
    /**
     * @var UserPasswordEncoderInterface $passwordEncoder
     */
    protected $passwordEncoder;

    /**
     * UserRepository constructor.
     *
     * @param ManagerRegistry              $registry
     * @param ValidatorInterface           $validator
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator, UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct($registry, User::class, $validator);
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param string $email
     * @param string $plainPassword
     *
     * @return User
     * @throws \Exception
     */
    public function create(string $email, string $plainPassword): User
    {
        try{
            $user = (new User())
                ->setEmail($email)
                ->setPlainPassword($plainPassword);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $plainPassword));
            $this->validate($user);

            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush();

            $user->setPlainPassword(null);

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $user;
    }
}
