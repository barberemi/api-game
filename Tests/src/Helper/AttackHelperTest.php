<?php

namespace App\Tests\src\Helper;

use App\Entity\Guild;
use PHPUnit\Framework\TestCase;
use App\Helper\AttackHelper;

/**
 * Class AttackHelperTest
 */
class AttackHelperTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testNightAttack()
    {
        $guild = (new Guild())->setId(1)->setCreatedAt((new \DateTime('now'))->modify('-1 day'));
        $nbMonsters = AttackHelper::nightAttack($guild);
        $this->assertGreaterThanOrEqual(2, $nbMonsters);
        $this->assertLessThanOrEqual(2, $nbMonsters);

        $guild->setCreatedAt((new \DateTime('now'))->modify('-4 day'));
        $nbMonsters = AttackHelper::nightAttack($guild);
        $this->assertGreaterThanOrEqual(3, $nbMonsters);
        $this->assertLessThanOrEqual(3, $nbMonsters);

        $guild->setCreatedAt((new \DateTime('now'))->modify('-50 day'))->setLastAttack(11);
        $nbMonsters = AttackHelper::nightAttack($guild);
        $this->assertGreaterThanOrEqual(22, $nbMonsters);
        $this->assertLessThanOrEqual(26, $nbMonsters);
    }
}
