<?php

namespace App\Repository;

use App\Entity\Map;
use App\Entity\Monster;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MapRepository extends AbstractRepository
{
    /**
     * MapRepository constructor.
     *
     * @param ManagerRegistry    $registry
     * @param ValidatorInterface $validator
     */
    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator)
    {
        parent::__construct($registry, Map::class, $validator);
    }

    /**
     * @param $entity
     *
     * @return mixed
     * @throws \Exception
     */
    public function update($entity)
    {
        $monsters = $entity->getMonsters();
        $keepIds = array_filter(array_map(function ($item) {
            return null !== $item->getId() ? $item->getId() : null;
        }, $monsters->toArray()));

        $this->clearMonsters($entity, $keepIds);

        /** @var Monster $monster */
        foreach ($monsters as $monster) {
            $monster->setMap($entity);
        }

        return parent::update($entity);
    }

    /**
     * @param Map   $map
     * @param array $keepIds
     *
     * @throws \Doctrine\ORM\ORMException
     */
    protected function clearMonsters(Map $map, array $keepIds): void
    {
        $monsters = $this->_em->getRepository(Monster::class)->findBy(['map' => $map]);

        /** @var Monster $monster */
        foreach ($monsters as $monster) {
            if (!in_array($monster->getId(), $keepIds)) {
                $monster->setMap(null);
            }
        }

        $this->_em->flush();
    }
}
