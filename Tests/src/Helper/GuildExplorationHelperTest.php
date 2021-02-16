<?php

namespace App\Tests\src\Helper;

use App\Entity\Guild;
use App\Entity\Monster;
use PHPUnit\Framework\TestCase;
use App\Helper\ExplorationHelper;

/**
 * Class GuildExplorationHelperTest
 */
class GuildExplorationHelperTest extends TestCase
{
    public function testGetGuildExploration()
    {
        $guild = (new Guild())->setId(1)->setName('Les tartiflettes');
        $boss = (new Monster())->setId(1)->setName('Boss 1')->setIsGuildBoss(true)->setImage('boss1.png')->setLevel(5);
        $boss2 = (new Monster())->setId(2)->setName('Boss 2')->setIsGuildBoss(true)->setImage('boss2.png')->setLevel(10);
        $boss3 = (new Monster())->setId(3)->setName('Boss 3')->setIsGuildBoss(true)->setImage('boss3.png')->setLevel(15);
        $boss4 = (new Monster())->setId(4)->setName('Boss 4')->setIsGuildBoss(true)->setImage('boss4.png')->setLevel(20);

        $exploration = ExplorationHelper::generate('guild', null, null, $guild, [$boss, $boss2, $boss3, $boss4]);

        $expetedResult = [
            0 => [
                0 => [
                    "id" => 1,
                    "next" => null,
                    "type" => "arene-boss",
                    'monster' => 1,
                    'image' => 'boss1.png',
                    'name' => 'Boss 1'
                ],
            ],
            1 => [
                0 => [
                    "id" => 2,
                    "next" => [
                        0 => 1,
                    ],
                    "type" => "arene-boss",
                    'monster' => 2,
                    'image' => 'boss2.png',
                    'name' => 'Boss 2'
                ]
            ],
            2 => [
                0 => [
                    "id" => 3,
                    "next" => [
                        0 => 2,
                    ],
                    "type" => "arene-boss",
                    'monster' => 3,
                    'image' => 'boss3.png',
                    'name' => 'Boss 3'
                ]
            ],
            3 => [
                0 => [
                    "id" => 4,
                    "next" => [
                        0 => 3,
                    ],
                    "type" => "arene-boss",
                    'monster' => 4,
                    'image' => 'boss4.png',
                    'name' => 'Boss 4'
                ]
            ],
            4 => [
                0 => [
                    "id" => 0,
                    "next" => [
                        0 => 4,
                    ],
                    "type" => "arene-boss",
                ]
            ],
        ];

        $this->assertEquals($expetedResult, $exploration);
    }
}
