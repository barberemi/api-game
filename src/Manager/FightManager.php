<?php

namespace App\Manager;

use App\Entity\Fight;
use App\Entity\OwnItem;
use App\Entity\User;
use App\Helper\FightHelper;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;

class FightManager extends AbstractManager
{
    /**
     * FightManager constructor.
     *
     * @param EntityManagerInterface $em
     * @param SerializerInterface    $serializer
     */
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        parent::__construct($em, $serializer, Fight::class);
    }

    /**
     * @param int   $id
     * @param array $data
     *
     * @return mixed
     * @throws \Exception
     */
    public function update(int $id, array $data)
    {
        $exist = $this->em->getRepository($this->repositoryNamespace)->find($id);

        if (!$exist) throw new \Exception(sprintf('Entity id %d doesnt exists.', $id));

        if (!array_key_exists('id', $data)) $data['id'] = $id;

        /** @var Fight $entity */
        $entity = $this->deserialize($data, ['update']);

        // 1 - Fight lost
        if ($entity->getType() === Fight::LOST_TYPE) {
            $user = $entity->getUser();
            $user->setExploration(null);
            $this->em->getRepository(User::class)->update($user);
        }

        // 2 - Fight won + reward not given
        if (!$entity->isRewarded() && $entity->getType() === Fight::WON_TYPE) {
            $user    = $entity->getUser();
            $monster = $entity->getMonster();
            $entity->setIsRewarded(true);

            // 1 - Add items on entity Fight & User
            /** @var OwnItem $item */
            foreach ($monster->getItems() as $item) {
                if (rand(0, 100) <= $item->getItem()->getDropRate() * 100) {
                    $newItemUser = (new OwnItem())->setItem($item->getItem())->setUser($user);
                    $user->addItem($newItemUser);

                    $newItemFight = (new OwnItem())->setItem($item->getItem())->setFight($entity);
                    $entity->addItem($newItemFight);
                }
            }

            // 2 - Add money & experience & items on User
            $user->setMoney(($user->getMoney() + $monster->getGivenMoney()));
            $user->setExperience(($user->getExperience() + $monster->getGivenXp()));

            // 3 - Boss fight : reset exploration
            if ($monster->getLevelTower() > 0) {
                $user->setExploration(null);
            }

            $this->em->getRepository(User::class)->update($user);
        }

        $entity = $this->em->getRepository($this->repositoryNamespace)->update($entity);

        return json_decode($this->serialize($entity));
    }

    /**
     * @param int $id
     *
     * @return mixed
     * @throws \Exception
     */
    public function getObject(int $id)
    {
        $fight  = $this->em->getRepository($this->repositoryNamespace)->find($id);

        if (!$fight) throw new \Exception(sprintf('Fight id %d doesnt exists.', $id));

        return $fight;
    }

    /**
     * @param Fight $fight
     * @return array|null
     */
    public function generateFight(Fight $fight): ?array
    {
        return FightHelper::generate($fight);
    }
}
