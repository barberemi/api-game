<?php

namespace App\Helper;


class LevelHelper
{
    const EXPONENTIAL = 1.15;
    const BASEXP = 100;

    /**
     * Get the Level from Xp given.
     *
     * @param int $xp
     *
     * @return int
     */
    static public function levelFromXp(int $xpGlobale): int
    {
        if ($xpGlobale < self::BASEXP) return 1;

        for ($i = 1; $i <= 100; $i++) {
            $xpNeeded = round(self::BASEXP / (self::EXPONENTIAL - 1) * self::EXPONENTIAL ** $i - self::BASEXP / (self::EXPONENTIAL - 1));

            if ($xpGlobale == $xpNeeded) return $i + 1;

            if ($xpGlobale < $xpNeeded) return $i;
        }

        return 100;
    }

    /**
     * Get the Level from Xp given.
     *
     * @param int $xp
     *
     * @return int
     */
    static public function xpMissingOnActualLevel(int $xpGlobale): int
    {
        if ($xpGlobale < self::BASEXP) return self::BASEXP - $xpGlobale;

        for ($i = 1; $i <= 100; $i++) {
            $xpNeeded = round(self::BASEXP / (self::EXPONENTIAL - 1) * self::EXPONENTIAL ** $i - self::BASEXP / (self::EXPONENTIAL - 1));

            if ($xpGlobale == $xpNeeded) return self::xpToLevel($i + 1);

            if ($xpGlobale < $xpNeeded) return $xpNeeded - $xpGlobale;
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
        return round(self::BASEXP * (self::EXPONENTIAL ** ($lvl - 1)));
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
        if ($lvl <= 1) {
            return 1;
        } else if ($lvl < 4) {
            return 2;
        } else if ($lvl < 7) {
            return 3;
        } else if ($lvl < 10) {
            return 4;
        } else {
            return 5;
        }
    }

    /**
     * Get woods receipe by level
     *
     * @param int $lvl
     *
     * @return int
     */
    static public function woodsByLevel(int $lvl): int
    {
        if ($lvl <= 1) {
            return 1;
        } else if ($lvl < 10) {
            return 2;
        } else if ($lvl < 20) {
            return 3;
        } else if ($lvl < 30) {
            return 4;
        } else if ($lvl < 40) {
            return 5;
        } else if ($lvl < 50) {
            return 6;
        } else if ($lvl < 60) {
            return 7;
        } else if ($lvl < 70) {
            return 8;
        } else if ($lvl < 80) {
            return 9;
        } else {
            return 10;
        }
    }
}
