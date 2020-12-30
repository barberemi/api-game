<?php

namespace App\Tests\src\Helper;

use App\Entity\Academy;
use App\Entity\BindCharacteristic;
use App\Entity\Characteristic;
use App\Entity\Item;
use App\Entity\Map;
use App\Entity\Monster;
use App\Entity\OwnItem;
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
        $health  = (new Characteristic())->setId(1)->setName('health');

        // Academy
        $bind    = (new BindCharacteristic())->setId(1)->setAmount(200)->setCharacteristic($health);
        $bind3   = (new BindCharacteristic())->setId(3)->setAmount(50)->setCharacteristic($health);
        $academy = (new Academy())->setId(1)->setName('warrior')->setLabel("Guerrier")->setBaseCharacteristics(new ArrayCollection([$bind]))->setCharacteristics(new ArrayCollection([$bind3]));

        // Item
        $bind2 = (new BindCharacteristic())->setId(2)->setAmount(200)->setCharacteristic($health);
        $item  = (new Item())->setId(1)->setName('Marteau')->setCharacteristics(new ArrayCollection([$bind2]));
        // EQUIPPED => count in the charactaristic
        $own1  = (new OwnItem())->setId(1)->setItem($item)->setIsEquipped(true);
        // NOT EQUIPPED => doesnt count in the charactaristic
        $own2  = (new OwnItem())->setId(1)->setItem($item)->setIsEquipped(false);

        $user    = (new User())->setId(1)->setEmail('totodanslasavane@gmail.com')->setName('Rem le chocorem')->setAcademy($academy)->setExperience(3000)->setMoney(2544)->setItems(new ArrayCollection([$own1, $own2]));
        $boss    = (new Monster())->setId(1)->setName('Elephant Man')->setLevelTower(1);
        $map     = (new Map())->setId(1)->setNbFloors(3)->setMonsters(new ArrayCollection([$boss]));

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
                "id" => 1,
                "name" => "Rem le chocorem",
                "money" => 2544,
                "academy" => [
                    "name" => "warrior",
                ],
                "position" => 8,
                'hp' => 500,
                'maxHp' => 500,
            ]
        ];

        $this->assertEquals($expetedResult, $exploration);

        $exploration = ExplorationHelper::moveToPosition($exploration, 7);
        $this->assertEquals(7, $exploration[array_key_last($exploration)]['position']);
    }
}
