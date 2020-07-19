<?php

namespace App\Repository;

use App\Entity\Academy;
use App\Entity\BindCharacteristic;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AcademyRepository extends AbstractRepository
{
    /**
     * AcademyRepository constructor.
     *
     * @param ManagerRegistry    $registry
     * @param ValidatorInterface $validator
     */
    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator)
    {
        parent::__construct($registry, Academy::class, $validator);
    }

    /**
     * @param $entity
     *
     * @return mixed
     * @throws \Exception
     */
    public function update($entity)
    {
        $baseCharacteristics = $entity->getBaseCharacteristics();
        $keepIds = array_filter(array_map(function ($item) {
            return null !== $item->getId() ? $item->getId() : null;
        }, $baseCharacteristics->toArray()));

        $this->clearBaseCharacteristics($entity, $keepIds);

        /** @var BindCharacteristic $characteristic */
        foreach ($baseCharacteristics as $characteristic) {
            $characteristic->setAcademy($entity);
        }

        return parent::update($entity);
    }

    /**
     * @param Academy $academy
     * @param array   $keepIds
     *
     * @throws \Doctrine\ORM\ORMException
     */
    protected function clearBaseCharacteristics(Academy $academy, array $keepIds): void
    {
        $bindCharacteristics = $this->_em->getRepository(BindCharacteristic::class)->findBy(['academy' => $academy]);

        /** @var BindCharacteristic $characteristic */
        foreach ($bindCharacteristics as $characteristic) {
            if (!in_array($characteristic->getId(), $keepIds)) {
                $this->_em->remove($characteristic);
            }
        }

        $this->_em->flush();
    }
}
