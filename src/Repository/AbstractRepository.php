<?php

namespace App\Repository;

use App\Entity\BindCharacteristic;
use App\Entity\Building;
use App\Entity\Construction;
use App\Entity\Crafting;
use App\Entity\Guild;
use App\Entity\OwnItem;
use App\Entity\User;
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

            // Check if needed to create construction (guild create or building create)
            $this->createConstructions($entity);
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

        // Check if items exist to clean them
        $this->checkItems($entity);

        // Check if Construction done
        $this->checkConstructionDone($entity);

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
        if (method_exists($entity, 'getCharacteristics') && get_class($entity) !== User::class) {
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

    /**
     * @param $entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function checkItems($entity) {
        if (method_exists($entity, 'getItems') || method_exists($entity, 'getItemsToCraft')) {
            $explode = explode('\\', $this->getEntityNameSpace());
            $entityName = end($explode);

            if (method_exists($entity, 'getItems')) {
                $items = $entity->getItems();
            } else {
                $items = $entity->getItemsToCraft();
            }

            $keepIds = array_filter(array_map(function ($item) {
                return null !== $item->getId() ? $item->getId() : null;
            }, $items->toArray()));

            $this->clearItems($entity, $entityName, $keepIds);

            foreach ($items as $item) {
                if (method_exists($entity, 'getItems')) {
                    $item->{'set'.ucwords($entityName)}($entity);
                } else {
                    $item->setItemToCraft($entity);
                }
            }
        }
    }

    /**
     * @param $entity
     * @param string $entityName
     * @param array $keepIds
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function clearItems($entity, string $entityName, array $keepIds): void
    {
        if (method_exists($entity, 'getItems')) {
            $oldItems = $this->_em->getRepository(OwnItem::class)->findBy([strtolower($entityName) => $entity]);
        } else {
            $oldItems = $this->_em->getRepository(Crafting::class)->findBy(['itemToCraft' => $entity]);
        }

        // Check if user & if have remaining bag space
        if (get_class($entity) === User::class) {
            if (count($keepIds) > count($oldItems) && $entity->getRemainingBagSpace() < 0) {
                throw new \Exception('Cant add new items, no bag space.');
            }
        }

        foreach ($oldItems as $item) {
            if (!in_array($item->getId(), $keepIds)) {
                $this->_em->remove($item);
            }
        }

        $this->_em->flush();
    }

    /**
     * @param $entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function createConstructions($entity) {
        if (method_exists($entity, 'getConstructions')) {
            $count = 0;

            // Guild/User creation : create all constructions buildings
            if (get_class($entity) === Guild::class || get_class($entity) === User::class) {
                $isUser = get_class($entity) === User::class;
                $buildings = $this->_em->getRepository(Building::class)->findBy(['isUserBuilding' => $isUser]);

                /** @var Building $building */
                foreach ($buildings as $building) {
                    $count++;
                    $construction = (new Construction())
                        ->setBuilding($building)
                        ->setRemainingActions($building->getNeededActions())
                        ->setRemainingMaterials($building->getNeededMaterials());

                    if ($isUser) {
                        $construction->setUser($entity);
                    } else {
                        $construction->setGuild($entity);
                    }

                    $this->_em->persist($construction);
                }
                $this->_em->flush();
            }

            // Building creation : create construction for all guilds/users
            if (get_class($entity) === Building::class) {
                $isUser = $entity->isUserBuilding();
                if ($isUser) {
                    $entitiesToFetch = $this->_em->getRepository(User::class)->findAll();
                } else {
                    $entitiesToFetch = $this->_em->getRepository(Guild::class)->findAll();
                }

                foreach ($entitiesToFetch as $data) {
                    $count++;
                    $construction = (new Construction())
                        ->setBuilding($entity)
                        ->setRemainingActions($entity->getNeededActions())
                        ->setRemainingMaterials($entity->getNeededMaterials());

                    if ($isUser) {
                        $construction->setUser($data);
                    } else {
                        $construction->setGuild($data);
                    }

                    $this->_em->persist($construction);

                    if ($count % 30 === 0) {
                        $this->_em->flush();
                    }
                }

                $this->_em->flush();
            }
        }
    }

    /**
     * @param $entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function checkConstructionDone($entity): void
    {
        if (get_class($entity) === Construction::class) {
            if ($entity->getStatus() !== Construction::DONE_STATUS) {
                if ($entity->getRemainingActions() === 0 && $entity->getRemainingMaterials() === 0) {
                    $entity->setStatus(Construction::DONE_STATUS);

                    $this->_em->flush();
                }
            }
        }
    }
}
