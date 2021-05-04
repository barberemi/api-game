<?php

namespace App\Helper;

use App\Entity\Guild;
use App\Entity\User;

class AttackHelper
{
    CONST NB_INITIAL_MONSTERS    = 2;
    CONST INCREASE_RATE_MONSTERS = 0.2;
    CONST MINIMUM_RATE_INTERVAL  = 80;
    CONST MAXIMUM_RATE_INTERVAL  = 120;

    /**
     * @param Guild $guild
     *
     * @return Guild
     *
     * @throws \Exception
     */
    static public function estimate(Guild $guild): Guild
    {
        $minInterval = self::minInterval($guild);
        $maxInterval = self::maxInterval($guild);

        $diff      = $maxInterval - $minInterval;
        $variation = round($diff / count($guild->getUsers()->filter(
            function(User $user) {
                return $user->getJob() && $user->getJob()->getName() === 'scout';
            }
        )) + 1);

        // Tirage Bas
        if (rand(1, $guild->getDownDraw() + $guild->getUpDraw()) <= $guild->getDownDraw()) {
            $result = $guild->getMinAttack() - $variation;
            $guild->setMinAttack($result > 0 ? $result : $variation);

            $guild->setDownDraw($guild->getDownDraw() - 1);
        } else {
        // Tirage Haut
            $result = $guild->getMaxAttack() - $variation;
            $guild->setMaxAttack($result > 0 ? $result : $variation);

            $guild->setUpDraw($guild->getUpDraw() - 1);
        }

        return $guild;
    }

    /**
     * @param Guild $guild
     *
     * @return int|null
     *
     * @throws \Exception
     */
    static public function nightAttack(Guild $guild): ?int
    {
        $difference = $guild->getCreatedAt()->diff((new \DateTime()));

        if ($difference->days < 1) {
            return self::NB_INITIAL_MONSTERS;
        }

        $monsters = self::newLastAttackMonsters($guild);
        $max      = self::newLastAttackMonsters($guild) * self::MAXIMUM_RATE_INTERVAL / 100;

        return rand($monsters, $max);
    }

    /**
     * @param Guild $guild
     * @return int|null
     */
    static public function newLastAttackMonsters(Guild $guild): ?int
    {
        $difference = $guild->getCreatedAt()->diff((new \DateTime()));

        return round($guild->getLastAttack() + self::NB_INITIAL_MONSTERS + ($difference->days * self::INCREASE_RATE_MONSTERS) / (100 + ($difference->days * self::INCREASE_RATE_MONSTERS)) * 100);
    }

    /**
     * @param Guild $guild
     * @return int|null
     */
    static public function minInterval(Guild $guild): ?int
    {
        return round(self::newLastAttackMonsters($guild) * self::MINIMUM_RATE_INTERVAL / 100);
    }

    /**
     * @param Guild $guild
     * @return int|null
     */
    static public function maxInterval(Guild $guild): ?int
    {
        return round(self::newLastAttackMonsters($guild) * self::MAXIMUM_RATE_INTERVAL / 100);
    }
}
