<?php

namespace App\Tests\src\Helper;

use PHPUnit\Framework\TestCase;
use App\Helper\LevelHelper;

/**
 * Class LevelHelperTest
 */
class LevelHelperTest extends TestCase
{
    public function testLevelFromXp()
    {
        $lvl = LevelHelper::levelFromXp(0);
        $this->assertEquals(0, $lvl);

        $lvl = LevelHelper::levelFromXp(1000);
        $this->assertEquals(1, $lvl);

        $lvl = LevelHelper::levelFromXp(3000);
        $this->assertEquals(2, $lvl);

        $lvl = LevelHelper::levelFromXp(5196);
        $this->assertEquals(3, $lvl);

        $lvl = LevelHelper::levelFromXp(1000000);
        $this->assertEquals(100, $lvl);
    }

    public function testXpToLevel()
    {
        $xp = LevelHelper::xpToLevel(1);
        $this->assertEquals(1000, $xp);

        $xp = LevelHelper::xpToLevel(2);
        $this->assertEquals(2828, $xp);

        $xp = LevelHelper::xpToLevel(3);
        $this->assertEquals(5196, $xp);

        $xp = LevelHelper::xpToLevel(100);
        $this->assertEquals(1000000, $xp);
    }

    public function testSkillPointsOfLevel()
    {
        $skillPoints = LevelHelper::skillPointsOfLevel(0);
        $this->assertEquals(1, $skillPoints);

        $skillPoints = LevelHelper::skillPointsOfLevel(2);
        $this->assertEquals(2, $skillPoints);

        $skillPoints = LevelHelper::skillPointsOfLevel(5);
        $this->assertEquals(3, $skillPoints);

        $skillPoints = LevelHelper::skillPointsOfLevel(9);
        $this->assertEquals(4, $skillPoints);

        $skillPoints = LevelHelper::skillPointsOfLevel(88);
        $this->assertEquals(5, $skillPoints);
    }
}
