<?php

namespace App\Manager;

use App\Entity\Item;
use App\Entity\Map;
use App\Entity\OwnItem;
use App\Entity\User;
use App\Helper\AttackHelper;
use App\Helper\ExplorationHelper;
use App\Helper\LevelHelper;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;

class UserManager extends AbstractManager
{
    /**
     * CharacteristicManager constructor.
     *
     * @param EntityManagerInterface $em
     * @param SerializerInterface    $serializer
     */
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        parent::__construct($em, $serializer, User::class);
    }

    /**
     * @param array $data
     *
     * @return array|mixed
     *
     * @throws \Exception
     */
    public function create(array $data)
    {
        $exist = $this->em->getRepository(User::class)->findBy(['email' => $data['email']]);

        if ($exist) {
            throw new \Exception('User with this email already exists.');
        }

        $data['plainPassword'] = $data['password'];

        return parent::create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function update(int $id, array $data)
    {
        $exist  = $this->em->getRepository(User::class)->find($id);

        if (!$exist) throw new \Exception(sprintf('User id %d doesnt exists.', $id));

        if(array_key_exists('canAction', $data) && $exist->isCanAction() && $exist->getGuild() && $exist->getJob()) {
            if ($exist->getJob()->getName() === 'scout') {
                // Scout
                AttackHelper::estimate($exist->getGuild());
            } else if ($exist->getJob()->getName() === 'minor' && $exist->getRemainingBagSpace() > 0) {
                // Minor
                $wood = $this->em->getRepository(Item::class)->findOneBy(['name' => 'Bois']);
                if ($wood) {
                    $nbWoods = LevelHelper::woodsByLevel($exist->getLevel());
                    for ($i = 1; $i <= $nbWoods; $i++) {
                        $exist->addItem((new OwnItem())->setItem($wood));
                    }
                }
            }
        }

        return parent::update($id, $data);
    }

    /**
     * @param array $data
     * @param int $idUser
     * @param int $idMap
     *
     * @return null|array
     *
     * @throws \Exception
     */
    public function generateExploration(array $data, int $idUser, int $idMap): ?array
    {
        if (!array_key_exists('type', $data)) {
            $data['type'] = 'treasure';
        }

        /** @var User $user */
        $user = $this->em->getRepository(User::class)->find($idUser);
        if (!$user) {
            throw new \Exception('User doesnt exists.');
        }

        /** @var Map $map */
        $map = $this->em->getRepository(Map::class)->find($idMap);
        if (!$map) {
            throw new \Exception('Map doesnt exists.');
        }

        $exploration = ExplorationHelper::generate($data['type'], $user, $map);
        $user->setExploration($exploration);
        $user = $this->em->getRepository(User::class)->softUpdate($user);

        return $user->getExploration();
    }

    /**
     * @param int $id
     *
     * @return null|mixed
     *
     * @throws \Exception
     */
    public function finishTreasureExploration(int $id)
    {
        /** @var User $user */
        $user = $this->em->getRepository(User::class)->find($id);
        if (!$user) {
            throw new \Exception('User doesnt exists.');
        }

        if (!$user->getExploration()) {
            throw new \Exception('User havent exploration.');
        }

        $exploration = $user->getExploration();
        $idMap       = $exploration[array_key_first($exploration)]['map'];

        $map = $this->em->getRepository(Map::class)->find($idMap);
        if (!$map) {
            throw new \Exception('No map existing with this id of user exploration.');
        }

        // Reset exploration user
        $user->setExploration(null);
        $item = null;
        if (sizeof($map->getItems()) > 0) {
            $ownItem = $map->getItems()[rand(0, sizeof($map->getItems()) - 1)];
            $item = (new OwnItem())->setItem($ownItem->getItem())->setUser($user);
            $user->addItem($item);
        }
        $this->em->getRepository(User::class)->softUpdate($user);

        return $item ? json_decode($this->serialize($item)) : null;
    }

    /**
     * @param int $id
     * @param array $data
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function addOrRemoveFriend(int $id, array $data)
    {
        $user = $this->em->getRepository(User::class)->find($id);
        if (!$user) {
            throw new \Exception('User with this id doesnt exists.');
        }

        $friend = $this->em->getRepository(User::class)->findOneBy(['email' => $data['email']]);
        if (!$friend) {
            throw new \Exception('User with this email doesnt exists.');
        }

        if (!array_key_exists('type', $data)) {
            throw new \Exception('No type to know if you want add or delete friend.');
        }

        if ($data['type'] === "add") {
            $user->addFriend($friend);
        } else {
            $user->removeFriend($friend);
        }

        $this->em->getRepository($this->repositoryNamespace)->update($user);

        return json_decode($this->serialize($user));
    }
}
