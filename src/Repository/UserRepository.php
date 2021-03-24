<?php

namespace App\Repository;

use App\Entity\Job;
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
     * @param User $user
     *
     * @return User
     * @throws \Exception
     */
    public function create($user): User
    {
        try{
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPlainPassword()));
            $user->setJob($this->_em->getRepository(Job::class)->findOneBy(['name' => 'villager']));

            $this->validate($user);

            $this->_em->persist($user);
            $this->_em->flush();

            $user->setPlainPassword(null);

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $user;
    }

    /**
     * @param $user
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function softUpdate(User $user)
    {
        try{
            $this->validate($user);

            $this->_em->merge($user);
            $this->_em->flush();

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $user;
    }
}
