<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

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
     * @param int $page
     *
     * @return Paginator
     */
    public function findByPageAndLimit(int $page): Paginator
    {
        $limit = $_ENV['LIMIT'];
        $query = $this->createQueryBuilder('p')
            ->getQuery()
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        return new Paginator($query);
    }

    /**
     * @param $entity
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function create($entity)
    {
        try{
            $this->validate($entity);

            $this->_em->persist($entity);
            $this->_em->flush();

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $entity;
    }

    /**
     * @param $entity
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function update($entity)
    {
        try{
            $this->validate($entity);

            $this->_em->merge($entity);
            $this->_em->flush();

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $entity;
    }

    /**
     * @param mixed $entity
     *
     * @return mixed
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete($entity)
    {
        $this->_em->remove($entity);
        $this->_em->flush();

        return $entity;
    }

    /**
     * Used on serializer.
     *
     * @return string
     */
    public function getEntityNameSpace()
    {
        return $this->getEntityName();
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
