<?php

namespace App\Helper;

use App\Entity\Guild;
use App\Entity\Map;
use App\Entity\Monster;
use App\Entity\OwnItem;
use App\Entity\User;

class ExplorationHelper
{
    /**
     * @var array
     */
    static protected $floors = [];

    /**
     * @var int
     */
    static protected $lastRoomId = 1;

    /**
     * @var bool
     */
    static protected $randomRoomsByFloor;

    /**
     * @var string
     */
    static protected $explorationType;

    /**
     * @param string $explorationType
     * @param null|User $user
     * @param null|Map $map
     * @param null|Guild $guild
     * @param null|array $boss
     * @param bool $randomRoomsByFloor
     * @return array
     */
    static public function generate(string $explorationType, ?User $user, ?Map $map, ?Guild $guild = null, array $boss = [], $randomRoomsByFloor = true)
    {
        ExplorationHelper::$randomRoomsByFloor = $randomRoomsByFloor;
        ExplorationHelper::$explorationType = $explorationType;

        if ($explorationType === 'guild') {
            for ($i = 0; $i < sizeof($boss); $i++) {
                ExplorationHelper::$floors[$i][] = [
                    'monster' => $boss[$i]->getId(),
                    'image'   => $boss[$i]->getImage(),
                    'name'    => $boss[$i]->getName(),
                    'id'      => ExplorationHelper::$lastRoomId,
                    'type'    => 'arene-boss',
                    'next'    => $i === 0 ? null : [ExplorationHelper::$lastRoomId - 1]
                ];
                ExplorationHelper::$lastRoomId = ExplorationHelper::$lastRoomId + 1;
            }
            ExplorationHelper::$floors[][] = [
                'id'      => 0,
                'type'    => 'arene-boss',
                'next'    => [ExplorationHelper::$lastRoomId - 1]
            ];
        } else {
            // Boss exploration
            if ($explorationType === 'boss') {
                ExplorationHelper::generateBoss($map);
            } else {
                // Treasure exploration
                ExplorationHelper::generateTreasure($map);
            }

            for ($i = 2; $i <= $map->getNbFloors() + 1; $i++) {
                ExplorationHelper::generateFloor($i, $map);
            }
            ExplorationHelper::$floors[][] = ExplorationHelper::generateRoom(count(ExplorationHelper::$floors) + 1, 1, 1);
            ExplorationHelper::generateUser($user);
        }

        return ExplorationHelper::$floors;
    }

    /**
     * @param User $user
     */
    static protected function generateUser(User $user): void
    {
        $health = $user->getSpecificCharacteristic($user->getCharacteristics(), 'health');

        /** @var OwnItem $equippedItem */
        foreach ($user->getEquippedItems() as $equippedItem) {
            $health = $health + $user->getSpecificCharacteristic($equippedItem->getItem()->getCharacteristics(), 'health');
        }

        ExplorationHelper::$floors[count(ExplorationHelper::$floors) + 1] = [
            'id'       => $user->getId(),
            'name'     => $user->getName(),
            'academy'  => [
                'name' => $user->getAcademy()->getName()
            ],
            'hp'       => $health,
            'maxHp'    => $health,
            'position' => ExplorationHelper::$lastRoomId,
        ];
    }

    /**
     * @param Map $map
     */
    static protected function generateBoss(Map $map): void
    {
        $boss = $map->getBoss();
        ExplorationHelper::$floors[ExplorationHelper::$lastRoomId] = [
            'id'     => ExplorationHelper::$lastRoomId,
            'idBoss' => $boss->getId(),
            'type'   => ExplorationHelper::getRoomType(1),
            'name'   => $boss->getName(),
            'image'  => $boss->getImage(),
            'map'    => $map->getId(),
        ];
    }

    /**
     * @param Map $map
     */
    static protected function generateTreasure(Map $map): void
    {
        $monsters = [];
        /** @var Monster $monster */
        foreach ($map->getMonsters() as $monster) {
            if (!$monster->isBoss() && !$monster->isGuildBoss()) {
                $monsters[] = $monster->getId();
            }
        }

        ExplorationHelper::$floors[ExplorationHelper::$lastRoomId] = [
            'id'       => ExplorationHelper::$lastRoomId,
            'idBoss'   => $monsters[rand(0, count($monsters) - 1)],
            'type'     => 'treasure',
            'map'      => $map->getId()
        ];
    }

    /**
     * @param int $idFloor
     * @param Map $map
     */
    static protected function generateFloor(int $idFloor, Map $map): void
    {
        $position = 1;
        $nbRooms = ExplorationHelper::$randomRoomsByFloor ? rand(2, 4) : 2; // Testing without random

        for ($i = 1; $i <= $nbRooms; $i++){
            ExplorationHelper::$floors[$idFloor][] = ExplorationHelper::generateRoom($idFloor, $nbRooms, $position, $map);
            $position = $position + 1;
        }
    }

    /**
     * @param int $idFloor
     * @param int $nbRooms
     * @param int $position
     * @param Map|null $map
     * @return array
     */
    static protected function generateRoom(int $idFloor, int $nbRooms, int $position, Map $map = null): array
    {
        ExplorationHelper::$lastRoomId = ExplorationHelper::$lastRoomId + 1;
        $type = ExplorationHelper::getRoomType($position);

        $monsters = [];
        if ($type === 'arene' && $map !== null) {
            /** @var Monster $monster */
            foreach ($map->getMonsters() as $monster) {
                if (!$monster->isBoss() && !$monster->isGuildBoss()) {
                    $monsters[] = $monster->getId();
                }
            }
            if (count($monsters) > 0) {
                $result['monster'] = $monsters[rand(0, count($monsters) - 1)];
            }
        }

        $items = [];
        if ($type === 'dealer' && $map !== null) {
            /** @var Monster $monster */
            foreach ($map->getMonsters() as $monster) {
                if (!$monster->isBoss() && !$monster->isGuildBoss()) {
                    /** @var OwnItem $ownItem */
                    foreach ($monster->getItems() as $ownItem) {
                        $items[] = $ownItem->getItem();
                    }
                }
            }
            if (count($items) > 0) {
                $result['item'] = $items[rand(0, count($items) - 1)]->getId();
                $result['cost'] = $items[rand(0, count($items) - 1)]->getCost();
            }
        }

        $result['id'] = ExplorationHelper::$lastRoomId;
        $result['type'] = $type;
        $result['next'] = ExplorationHelper::getNextRoomId($idFloor, $nbRooms, $position);

        return $result;
    }

    /**
     * @param int $idFloor
     * @param int $nbRooms
     * @param int $position
     * @return array
     */
    static protected function getNextRoomId(int $idFloor, int $nbRooms, int $position): array
    {
        $keepNextIds = [];

        if ($idFloor === 2) return [1];

        $tabPossibleNext = [
            1 => [ // 1 top rank
                1 => [ // 1 bottom rank
                    1 => [1] // pos 1
                ]
            ],
            2 => [ // 2 top ranks
                1 => [ // 1 bottom ranks
                    1 => [1, 2], // pos 1
                ],
                2 => [ // 2 bottom ranks
                    1 => [1], // pos 1
                    2 => [2], // pos 2
                ],
                3 => [ // 3 bottom ranks
                    1 => [1], // pos 1
                    2 => [1, 2], // pos 2
                    3 => [2], // pos 3
                ],
                4 => [ // 4 bottom ranks
                    1 => [1], // pos 1
                    2 => [1], // pos 2
                    3 => [2], // pos 3
                    4 => [2], // pos 4
                ],
            ],
            3 => [ // 3 top ranks
                1 => [ // 2 bottom ranks
                    1 => [1, 2, 3], // pos 1
                ],
                2 => [ // 2 bottom ranks
                    1 => [1, 2], // pos 1
                    2 => [2, 3], // pos 2
                ],
                3 => [ // 3 bottom ranks
                    1 => [1], // pos 1
                    2 => [1, 2, 3], // pos 2
                    3 => [3], // pos 3
                ],
                4 => [ // 4 bottom ranks
                    1 => [1], // pos 1
                    2 => [1, 2], // pos 2
                    3 => [2, 3], // pos 3
                    4 => [3], // pos 4
                ],
            ],
            4 => [ // 4 top ranks
                1 => [ // 2 bottom ranks
                    1 => [1, 2, 3, 4], // pos 1
                ],
                2 => [ // 2 bottom ranks
                    1 => [1, 2], // pos 1
                    2 => [3, 4], // pos 2
                ],
                3 => [ // 3 bottom ranks
                    1 => [1, 2], // pos 1
                    2 => [2, 3], // pos 2
                    3 => [3, 4], // pos 3
                ],
                4 => [ // 4 bottom ranks
                    1 => [1], // pos 1
                    2 => [1, 2], // pos 2
                    3 => [3, 4], // pos 3
                    4 => [4], // pos 4
                ],
            ],
        ];

        foreach ($tabPossibleNext[count(ExplorationHelper::$floors[$idFloor - 1])][$nbRooms][$position] as $next) {
            $keepNextIds[] = ExplorationHelper::$floors[$idFloor - 1][$next - 1]['id'];
        }

        return $keepNextIds;
    }

    /**
     * @param int $position
     * @return string
     */
    static protected function getRoomType(int $position): string
    {
        $types = ['arene-boss', 'arene', 'dealer', 'healer'];

        if (count(ExplorationHelper::$floors) === 0) return $types[0]; // Boss
        if (
            ($position === 1 && count(ExplorationHelper::$floors) === 1) ||
            ($position !== 1 && count(ExplorationHelper::$floors) === 2)
        ) return $types[3]; // Healer after boss

        return $types[ExplorationHelper::$randomRoomsByFloor ? rand(1, 3) : 1];  // Testing without random
    }
}
