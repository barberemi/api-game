<?php

namespace App\Helper;

use App\Entity\Fight;
use App\Entity\Monster;
use App\Entity\OwnItem;
use App\Entity\Skill;
use App\Entity\User;

class FightHelper
{
    /**
     * @param Fight $fight
     * @return array
     */
    static public function generate(Fight $fight)
    {
        return [
            'type'    => $fight->getType(),
            'user'    => FightHelper::generateUser($fight),
            'monster' => FightHelper::generateMonster($fight),
        ];
    }

    /**
     * @param Fight $fight
     * @return array
     */
    static protected function generateUser(Fight $fight): array
    {
        $characteristics = $fight->getUser()->getCharacteristics();

        $health = $fight->getUser()->getExploration()
            ? $fight->getUser()->getExploration()[array_key_last($fight->getUser()->getExploration())]['hp']
            : 100;
        $maxHealth = $fight->getUser()->getExploration()
            ? $fight->getUser()->getExploration()[array_key_last($fight->getUser()->getExploration())]['maxHp']
            : 100;

        if ($fight->getMonster()->isGuildBoss()) {
            $health = $fight->getUser()->getSpecificCharacteristic($characteristics, 'health');

            /** @var OwnItem $equippedItem */
            foreach ($fight->getUser()->getEquippedItems() as $equippedItem) {
                $health = $health + $fight->getUser()->getSpecificCharacteristic($equippedItem->getItem()->getCharacteristics(), 'health');
            }
            $maxHealth = $health;
        }

        return [
            'id'     => $fight->getUser()->getId(),
            'email'  => $fight->getUser()->getEmail(),
            'name'   => $fight->getUser()->getName(),
            'image'  => $fight->getUser()->getAcademy()->getName(),
            'me'     => true,
            'level'  => $fight->getUser()->getLevel(),
            'hp'     => $health,
            'maxHp'  => $maxHealth,
            'skills' => FightHelper::getSkills($fight->getUser(), $characteristics),
        ];
    }

    /**
     * @param Fight $fight
     * @return array
     */
    static protected function generateMonster(Fight $fight): array
    {
        $characteristics = $fight->getMonster()->getCharacteristics();
        $health = $fight->getMonster()->getSpecificCharacteristic($characteristics, 'health');

        return [
            'id'     => $fight->getMonster()->getId(),
            'name'   => $fight->getMonster()->getName(),
            'image'  => $fight->getMonster()->getImage(),
            'level'  => $fight->getMonster()->getLevel(),
            'hp'     => $health,
            'maxHp'  => $health,
            'skills' => FightHelper::getSkills($fight->getMonster(), $characteristics),
            'isGuildBoss' => $fight->getMonster()->isGuildBoss(),
        ];
    }

    /**
     * @param User|Monster $entity
     * @param mixed $characteristics
     * @return array
     */
    static protected function getSkills($entity, $characteristics): array
    {
        $results = [];

        /** @var Skill $skill */
        foreach ($entity->getSkills() as $skill) {
            $amount = 0;
            if (get_class($entity) === User::class) {
                /** @var OwnItem $equippedItem */
                foreach ($entity->getEquippedItems() as $equippedItem) {
                    $amount = $amount + $entity->getSpecificCharacteristic($equippedItem->getItem()->getCharacteristics(), $skill->getScaleType());
                }
            }

            $amount = round($skill->getAmount() + (
                $skill->getScaleType()
                ? $skill->getRate() * ($entity->getSpecificCharacteristic($characteristics, $skill->getScaleType()) + $amount)
                : 0));

            $results[] = [
                'id'             => $skill->getId(),
                'name'           => $skill->getName(),
                'color'          => $skill->getAcademy()->getColor(),
                'description'    => str_replace('#MONTANT#', $amount, $skill->getDescription()),
                'amount'         => $amount,
                'effect'         => $skill->getType(),
                'duration'       => $skill->getDuration(),
                'cooldown'       => $skill->getCooldown(),
                'image'          => $skill->getImage(),
                'nbBlockedTurns' => 0
            ];
        }

        return $results;
    }
}
