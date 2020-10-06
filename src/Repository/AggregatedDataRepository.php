<?php

namespace App\Repository;

use App\Entity\Guild;
use App\Entity\Item;
use App\Entity\Monster;
use App\Entity\User;
use App\Helper\LevelHelper;
use Doctrine\ORM\EntityManagerInterface;

class AggregatedDataRepository
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * AggregatedDataRepository constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return array
     */
    public function getDashboardData()
    {
        $result = [];

        // 1 - Users data
        $users = $this->em->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->orderBy('u.id', 'asc')
            ->getQuery()
            ->getArrayResult()
        ;
        if ($users) {
            $user = current($users);
            $user['level'] = LevelHelper::levelFromXp($user['experience']);
            $result['nb_users'] = count($users);
            $result['last_user'] = $user;
        }

        // 2 - Guilds data
        $guilds = $this->em->createQueryBuilder()
            ->select('g')
            ->from(Guild::class, 'g')
            ->orderBy('g.id', 'asc')
            ->getQuery()
            ->getArrayResult()
        ;
        if ($guilds) {
            $result['nb_guilds'] = count($guilds);
            $result['last_guild'] = current($guilds);
        }

        // 3 - Monsters data
        $monsters = $this->em->createQueryBuilder()
            ->select('m')
            ->from(Monster::class, 'm')
            ->orderBy('m.id', 'asc')
            ->getQuery()
            ->getArrayResult()
        ;
        if ($monsters) {
            $result['nb_monsters'] = count($monsters);
            $result['last_monster'] = current($monsters);
        }

        // 4 - Items data
        $items = $this->em->createQueryBuilder()
            ->select('i')
            ->from(Item::class, 'i')
            ->orderBy('i.id', 'asc')
            ->getQuery()
            ->getArrayResult()
        ;
        if ($items) {
            $result['nb_items'] = count($items);
            $result['last_item'] = current($items);
        }

        return $result;
    }
}
