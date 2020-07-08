<?php

namespace tests\src\Helper;

use PHPUnit\Framework\TestCase;
use App\Helper\LevelHelper;

/**
 * Class LogManagerTest
 */
class LogManagerTest extends TestCase
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
}
