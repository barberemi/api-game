<?php

namespace App\Tests\src\Helper;

use App\Entity\Academy;
use App\Entity\BindCharacteristic;
use App\Entity\Characteristic;
use App\Entity\Fight;
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
                "email" => "Gros joueur",
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
        $bind2  = (new BindCharacteristic())->setId(2)->setAmount(200)->setCharacteristic($health);

        // Academy
        $warrior = (new Academy())->setId(1)->setName('warrior')->setBaseCharacteristics(new ArrayCollection([$bind2]))->setColor('#ffffff');

        // Skills
        $skill1 = (new Skill())->setId(1)->setName('Premier skill')->setDescription('Premier skill description')
            ->setAmount(50)->setAcademy($warrior)->setImage('premier-skill.png');
        $skill2 = (new Skill())->setId(2)->setName('Second skill')->setDescription('Second skill description')
            ->setAmount(100)->setRate(0.7)->setScaleType('health')->setAcademy($warrior)->setImage('second-skill.png');

        $user = (new User())
            ->setId(1)->setEmail('totodanslasavane@gmail.com')->setName('Gros joueur')->setExperience(3000)
            ->setExploration($exploration)->setSkills(new ArrayCollection([$skill1, $skill2]))->setAcademy($warrior);
        $monster = (new Monster())
            ->setId(1)->setName('Elephant Man')->setImage('elephant-man')->setSkills(new ArrayCollection([$skill1]))
            ->setLevel(44)->setIsBoss(true)->setCharacteristics(new ArrayCollection([$bind]));
        $fight = (new Fight())->setId(1)->setUser($user)->setMonster($monster)->setType(Fight::WAITING_TYPE);

        $fight = FightHelper::generate($fight);

        $expetedResult = [
            "type" => "waiting",
            "user" => [
                "id" => 1,
                "email" => "totodanslasavane@gmail.com",
                "name" => "Gros joueur",
                "image" => "warrior",
                "me" => true,
                "level" => 2,
                "hp" => 500,
                "maxHp" => 500,
                "skills" => [
                    [
                        'id'             => 1,
                        'name'           => "Premier skill",
                        'description'    => "Premier skill description",
                        'amount'         => 50.0,
                        'effect'         => "melee",
                        'duration'       => 0,
                        'nbBlockedTurns' => 0,
                        'color'          => '#ffffff',
                        'cooldown'       => 0,
                        'image'          => 'premier-skill.png'
                    ],
                    [
                        'id'             => 2,
                        'name'           => "Second skill",
                        'description'    => "Second skill description",
                        'amount'         => 240.0,
                        'effect'         => "melee",
                        'duration'       => 0,
                        'nbBlockedTurns' => 0,
                        'color'          => '#ffffff',
                        'cooldown'       => 0,
                        'image'          => 'second-skill.png'
                    ],
                ],
            ],
            "monster" => [
                "id" => 1,
                "name" => "Elephant Man",
                "image" => "elephant-man",
                "level" => 44,
                'hp' => 500,
                'maxHp' => 500,
                "skills" => [
                    [
                        'id'             => 1,
                        'name'           => "Premier skill",
                        'description'    => "Premier skill description",
                        'amount'         => 50.0,
                        'effect'         => "melee",
                        'duration'       => 0,
                        'nbBlockedTurns' => 0,
                        'color'          => '#ffffff',
                        'cooldown'       => 0,
                        'image'          => 'premier-skill.png'
                    ],
                ],
            ]
        ];

        $this->assertEquals($expetedResult, $fight);
    }
}
