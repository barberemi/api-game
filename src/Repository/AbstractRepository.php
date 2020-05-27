<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractRepository extends ServiceEntityRepository
{
    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * AbstractRepository constructor.
     *
     * @param ManagerRegistry    $registry
     * @param string             $entityClass
     * @param ValidatorInterface $validator
     */
    public function __construct(ManagerRegistry $registry, string $entityClass, ValidatorInterface $validator)
    {
        parent::__construct($registry, $entityClass);
        $this->validator = $validator;
    }

    /**
     * @param $entity
     *
     * @throws \Exception
     */
    public function validate($entity)
    {
        $violations = $this->validator->validate($entity);

        if ($violations->count() > 0) {
            throw new \Exception($violations->get(0)->getMessage());
        }
    }
}
