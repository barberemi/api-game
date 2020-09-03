<?php

namespace App\Repository;

use App\Entity\BindCharacteristic;
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
        // Check if characteristics exist to clean them
        $this->checkCharacteristics($entity);

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

    /**
     * @param $entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function checkCharacteristics($entity) {
        if (method_exists($entity, 'getCharacteristics')) {
            $explode = explode('\\', $this->getEntityNameSpace());
            $entityName = end($explode);

            $characteristics = $entity->getCharacteristics();
            $keepIds = array_filter(array_map(function ($item) {
                return null !== $item->getId() ? $item->getId() : null;
            }, $characteristics->toArray()));

            $this->clearCharacteristics($entity, $entityName, $keepIds);

            /** @var BindCharacteristic $characteristic */
            foreach ($characteristics as $characteristic) {
                $characteristic->{'set'.ucwords($entityName)}($entity);
            }
        }
    }

    /**
     * @param mixed  $entity
     * @param string $entityName
     * @param array  $keepIds
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function clearCharacteristics($entity, string $entityName, array $keepIds): void
    {
        $bindCharacteristics = $this->_em->getRepository(BindCharacteristic::class)->findBy([strtolower($entityName) => $entity]);

        /** @var BindCharacteristic $characteristic */
        foreach ($bindCharacteristics as $characteristic) {
            if (!in_array($characteristic->getId(), $keepIds)) {
                $this->_em->remove($characteristic);
            }
        }

        $this->_em->flush();
    }
}
