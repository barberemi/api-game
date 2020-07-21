<?php

namespace App\Repository;

use App\Entity\BindCharacteristic;
use App\Entity\Monster;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MonsterRepository extends AbstractRepository
{
    /**
     * MonsterRepository constructor.
     *
     * @param ManagerRegistry    $registry
     * @param ValidatorInterface $validator
     */
    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator)
    {
        parent::__construct($registry, Monster::class, $validator);
    }

    /**
     * @param $entity
     *
     * @return mixed
     * @throws \Exception
     */
    public function update($entity)
    {
        $characteristics = $entity->getCharacteristics();
        $keepIds = array_filter(array_map(function ($item) {
            return null !== $item->getId() ? $item->getId() : null;
        }, $characteristics->toArray()));

        $this->clearCharacteristics($entity, $keepIds);

        /** @var BindCharacteristic $characteristic */
        foreach ($characteristics as $characteristic) {
            $characteristic->setMonster($entity);
        }

        return parent::update($entity);
    }

    /**
     * @param Monster $monster
     * @param array   $keepIds
     *
     * @throws \Doctrine\ORM\ORMException
     */
    protected function clearCharacteristics(Monster $monster, array $keepIds): void
    {
        $bindCharacteristics = $this->_em->getRepository(BindCharacteristic::class)->findBy(['monster' => $monster]);

        /** @var BindCharacteristic $characteristic */
        foreach ($bindCharacteristics as $characteristic) {
            if (!in_array($characteristic->getId(), $keepIds)) {
                $this->_em->remove($characteristic);
            }
        }

        $this->_em->flush();
    }
}
