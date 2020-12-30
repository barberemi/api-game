<?php

namespace App\Tests\src\Helper;

use App\Entity\BindCharacteristic;
use App\Entity\Characteristic;
use App\Entity\Monster;
use App\Entity\Skill;
use App\Entity\User;
use App\Helper\FightHelper;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

/**
 * Class FightHelperTest
 */
class FightHelperTest extends TestCase
{
    public function testGenerate()
    {
        $exploration = [
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
                "name" => "totodanslasavane@gmail.com",
                "money" => 2544,
                "academy" => [
                    "name" => "warrior",
                ],
                "position" => 8,
                'hp' => 500,
                'maxHp' => 500,
            ]
        ];

        // Characteristics
        $health = (new Characteristic())->setId(1)->setName('health');
        $bind   = (new BindCharacteristic())->setId(1)->setAmount(500)->setCharacteristic($health);

        // Skills
        $skill1 = (new Skill())->setId(1)->setName('Premier skill')->setDescription('Premier skill description')
            ->setAmount(50)->setRate(0.5);
        $skill2 = (new Skill())->setId(2)->setName('Second skill')->setDescription('Second skill description')
            ->setAmount(100)->setRate(0.7);

        $user = (new User())
            ->setId(1)->setEmail('totodanslasavane@gmail.com')->setExperience(3000)
            ->setExploration($exploration)->setSkills(new ArrayCollection([$skill1, $skill2]));
        $monster = (new Monster())
            ->setId(1)->setName('Elephant Man')->setSkills(new ArrayCollection([$skill1]))
            ->setLevel(44)->setLevelTower(1)->setCharacteristics(new ArrayCollection([$bind]));;

        $fight = FightHelper::generate($user, $monster);

        $expetedResult = [
            "users" => [
                0 => [
                    "id" => 1,
                    "name" => "totodanslasavane@gmail.com",
                    "me" => true,
                    "level" => 2,
                    "hp" => 500,
                    "maxHp" => 500,
                    "skills" => [
                        [
                            'id'             => 1,
                            'name'           => "Premier skill",
                            'description'    => "Premier skill description",
                            'amount'         => 25.0,
                            'effect'         => "melee",
                            'duration'       => 0,
                            'nbBlockedTurns' => 0
                        ],
                        [
                            'id'             => 2,
                            'name'           => "Second skill",
                            'description'    => "Second skill description",
                            'amount'         => 70.0,
                            'effect'         => "melee",
                            'duration'       => 0,
                            'nbBlockedTurns' => 0
                        ],
                    ],
                ]
            ],
            "monster" => [
                "id" => 1,
                "name" => "Elephant Man",
                "level" => 44,
                'hp' => 500,
                'maxHp' => 500,
                "skills" => [
                    [
                        'id'             => 1,
                        'name'           => "Premier skill",
                        'description'    => "Premier skill description",
                        'amount'         => 25.0,
                        'effect'         => "melee",
                        'duration'       => 0,
                        'nbBlockedTurns' => 0
                    ],
                ],
            ]
        ];

        $this->assertEquals($expetedResult, $fight);
    }
}
