<?php

namespace App\Helper;

use App\Entity\Monster;
use App\Entity\Skill;
use App\Entity\User;
use Doctrine\Common\Collections\Collection;

class FightHelper
{
    /**
     * @param User $user
     * @param Monster $monster
     * @return array
     */
    static public function generate(User $user, Monster $monster)
    {
        return [
            'users' => [
                FightHelper::generateUser($user),
            ],
            'monster' => FightHelper::generateMonster($monster),
        ];
    }

    /**
     * @param User $user
     * @return array
     */
    static protected function generateUser(User $user): array
    {
        return [
            'id'     => $user->getId(),
            'name'   => $user->getEmail(),
            'me'     => true,
            'level'  => $user->getLevel(),
            'hp'     => $user->getExploration() ? $user->getExploration()[array_key_last($user->getExploration())]['hp'] : 100,
            'maxHp'  => $user->getExploration() ? $user->getExploration()[array_key_last($user->getExploration())]['maxHp'] : 100,
            'skills' => FightHelper::getSkills($user->getSkills()),
        ];
    }

    /**
     * @param Monster $monster
     * @return array
     */
    static protected function generateMonster(Monster $monster): array
    {
        $health = $monster->getSpecificCharacteristic($monster->getCharacteristics(), 'health');

        return [
            'id'     => $monster->getId(),
            'name'   => $monster->getName(),
            'level'  => $monster->getLevel(),
            'hp'     => $health,
            'maxHp'  => $health,
            'skills' => FightHelper::getSkills($monster->getSkills()),
        ];
    }

    /**
     * @param Collection $skills
     * @return array
     */
    static protected function getSkills(Collection $skills): array
    {
        $results = [];
        /** @var Skill $skill */
        foreach ($skills as $skill) {
            $results[] = [
                'id'             => $skill->getId(),
                'name'           => $skill->getName(),
                'description'    => $skill->getDescription(),
                'amount'         => $skill->getAmount() * $skill->getRate(),
                'effect'         => $skill->getType(),
                'duration'       => $skill->getDuration(),
                'nbBlockedTurns' => 0
            ];
        }

        return $results;
    }
}
