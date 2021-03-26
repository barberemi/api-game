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
     * @param $entity
     *
     * @return User
     * @throws \Exception
     */
    public function create($entity): User
    {
        try{
            $entity->setPassword($this->passwordEncoder->encodePassword($entity, $entity->getPlainPassword()));
            $entity->setJob($this->_em->getRepository(Job::class)->findOneBy(['name' => 'villager']));

            parent::create($entity);

            $entity->setPlainPassword(null);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $entity;
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
