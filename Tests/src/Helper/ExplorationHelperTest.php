<?php

namespace App\Tests\src\Helper;

use App\Entity\Map;
use App\Entity\Monster;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use App\Helper\ExplorationHelper;

/**
 * Class ExplorationHelperTest
 */
class ExplorationHelperTest extends TestCase
{
    public function testGetExploration()
    {
        $user = (new User())->setId(1)->setEmail('totodanslasavane@gmail.com');
        $boss = (new Monster())->setId(1)->setName('Elephant Man')->setLevelTower(1);
        $map  = (new Map())->setId(1)->setNbFloors(3)->setMonsters(new ArrayCollection([$boss]));

        $exploration = ExplorationHelper::generate($user, $map, false);

        $expetedResult = [
            1 => [
                "id" => 1,
                "type" => "arene-boss",
                "name" => "Elephant Man",
                "image" => "boss1-portrait.png",
            ],
            2 => [
                0 => [
                    "id" => 2,
                    "next" => [
                        0 => 1,
                    ],
                    "type" => "healer",
                ],
                1 => [
                    "id" => 3,
                    "next" => [
                        0 => 1,
                    ],
                    "type" => "healer",
                ],
            ],
            3 => [
                0 => [
                    "id" => 4,
                    "next" => [
                        0 => 2,
                        1 => 3,
                    ],
                    "type" => "arene",
                ],
                1 => [
                    "id" => 5,
                    "next" => [
                        0 => 2,
                        1 => 3,
                    ],
                    "type" => "arene",
                ],
            ],
            4 => [
                0 => [
                    "id" => 6,
                    "next" => [
                        0 => 4,
                        1 => 5,
                    ],
                    "type" => "arene",
                ],
                1 => [
                    "id" => 7,
                    "next" => [
                        0 => 4,
                        1 => 5,
                    ],
                    "type" => "arene",
                ],
            ],
            5 => [
                0 => [
                    "id" => 8,
                    "next" => [
                        0 => 6,
                        1 => 7,
                    ],
                    "type" => "arene",
                ],
            ],
            6 => [
                "name" => "totodanslasavane@gmail.com",
                "image" => "warrior.png",
                "position" => 8,
            ]
        ];

        $this->assertEquals($expetedResult, $exploration);

        $exploration = ExplorationHelper::moveToPosition($exploration, 7);
        $this->assertEquals(7, $exploration[array_key_last($exploration)]['position']);
    }
}
