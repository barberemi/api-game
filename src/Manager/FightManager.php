<?php

namespace App\Manager;

use App\Entity\Fight;
use App\Entity\Guild;
use App\Entity\Monster;
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
        $hp = null;
        $exist = $this->em->getRepository($this->repositoryNamespace)->find($id);

        if (!$exist) throw new \Exception(sprintf('Entity id %d doesnt exists.', $id));

        if (!array_key_exists('id', $data)) $data['id'] = $id;

        if (array_key_exists('hp', $data)) {
            $hp = $data['hp'];
            unset($data['hp']);
        }

        /** @var Fight $entity */
        $entity = $this->deserialize($data, ['update']);

        // 1 - Fight lost (Exploration Fight)
        if (!$entity->getMonster()->isGuildBoss() && $entity->getType() === Fight::LOST_TYPE) {
            $user = $entity->getUser();
            $user->setExploration(null);
            $this->em->getRepository(User::class)->update($user);
        }

        // 2 - Fight won + reward not given
        if (!$entity->isRewarded() && $entity->getType() === Fight::WON_TYPE) {
            $user    = $entity->getUser();
            $monster = $entity->getMonster();
            $entity->setIsRewarded(true);

            // 1 - Add items on entity Fight & User if bag space can
            /** @var OwnItem $item */
            foreach ($monster->getItems() as $item) {
                if (rand(0, 100) <= $item->getItem()->getDropRate() * 100) {
                    if ($user->getRemainingBagSpace() > 0) {
                        $newItemUser = (new OwnItem())->setItem($item->getItem())->setUser($user);
                        $user->addItem($newItemUser);

                        $newItemFight = (new OwnItem())->setItem($item->getItem())->setFight($entity);
                        $entity->addItem($newItemFight);
                    }
                }
            }

            // 2 - Add money & experience
            $user->setMoney(($user->getMoney() + $monster->getGivenMoney()));
            $user->setExperience(($user->getExperience() + $monster->getGivenXp()));

            // 3 - Guild Boss : check if needed to increment guild position
            if ($monster->isGuildBoss()) {
                $guildBoss = $this->em->getRepository(Monster::class)->findBy(
                    ['isGuildBoss' => true],
                    ['level' => 'asc']
                );
                $position = $user->getGuild()->getPosition();

                if ($monster->getId() === $guildBoss[$position]->getId()) {
                    $guild = $user->getGuild();
                    $guild->setPosition($guild->getPosition() + 1);
                    $this->em->getRepository(Guild::class)->update($guild);
                }
            } else {
                // 4 - Last exploration fight : reset exploration (Exploration Fight)
                $exploration = $user->getExploration();
                if ($exploration[array_key_last($exploration)]['position'] === '1' &&
                    $exploration[array_key_first($exploration)]['type'] !== 'treasure'
                ) {
                    $user->setExploration(null);
                } else {
                    // 4 - Hp user exploration
                    $exploration[array_key_last($exploration)]['hp'] = $hp;
                    $user->setExploration($exploration);
                }
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
