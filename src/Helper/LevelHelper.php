<?php

namespace App\Helper;


class LevelHelper
{
    const EXPONENTIAL = 1.5;
    const BASEXP = 1000;

    /**
     * Get the Level from Xp given.
     *
     * @param int $xp
     *
     * @return int
     */
    static public function levelFromXp(int $xp): int
    {
        if ($xp < self::BASEXP) return 0;

        for ($i = 1; $i <= 100; $i++) {
            $xpNeeded = round(self::BASEXP * ($i ** self::EXPONENTIAL));

            if ($xp == $xpNeeded) return $i;

            if ($xp < $xpNeeded) return $i-1;
        }

        return 100;
    }

    /**
     * Get Xp needed for Level given.
     *
     * @param int $lvl
     *
     * @return int
     */
    static public function xpToLevel(int $lvl): int
    {
        return round(self::BASEXP * ($lvl ** self::EXPONENTIAL));
    }
}
