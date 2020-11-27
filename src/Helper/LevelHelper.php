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

    /**
     * Get skill points from level
     *
     * @param int $lvl
     *
     * @return int
     */
    static public function skillPointsOfLevel(int $lvl): int
    {
        $tab = [
            0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4,
            5 => 5, 6 => 5, 7 => 5, 8 => 5, 9 => 5,

            10 => 6, 11 => 6, 12 => 6, 13 => 6, 14 => 6,
            15 => 7, 16 => 7, 17 => 7, 18 => 7, 19 => 7,

            20 => 8, 21 => 8, 22 => 8, 23 => 8, 24 => 8,
            25 => 10, 26 => 10, 27 => 10, 28 => 10, 29 => 10,

            30 => 11, 31 => 11, 32 => 11, 33 => 11, 34 => 11,
            35 => 12, 36 => 12, 37 => 12, 38 => 12, 39 => 12,

            40 => 13, 41 => 13, 42 => 13, 43 => 13, 44 => 13,
            45 => 14, 46 => 14, 47 => 14, 48 => 14, 49 => 14,

            50 => 16, 51 => 16, 52 => 16, 53 => 16, 54 => 16,
            55 => 17, 56 => 17, 57 => 17, 58 => 17, 59 => 17,

            60 => 18, 61 => 18, 62 => 18, 63 => 18, 64 => 18,
            65 => 19, 66 => 19, 67 => 19, 68 => 19, 69 => 19,

            70 => 20, 71 => 20, 72 => 20, 73 => 20, 74 => 20,
            75 => 22, 76 => 22, 77 => 22, 78 => 22, 79 => 22,

            80 => 23, 81 => 23, 82 => 23, 83 => 23, 84 => 23,
            85 => 24, 86 => 24, 87 => 24, 88 => 24, 89 => 24,

            90 => 25, 91 => 25, 92 => 25, 93 => 25, 94 => 25,
            95 => 26, 96 => 27, 97 => 28, 98 => 29, 99 => 30,
        ];


        return array_key_exists($lvl, $tab) ? $tab[$lvl] : 30;
    }
}
