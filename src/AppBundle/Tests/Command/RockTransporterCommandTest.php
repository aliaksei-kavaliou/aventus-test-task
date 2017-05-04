<?php

namespace AppBundle\Tests\Command;

use PHPUnit\Framework\TestCase;
use AppBundle\Command\RockTransporterCommand;

/**
 * RockTransporterCommandTest
 *
 * @author aliaksei
 */
class RockTransporterCommandTest extends TestCase
{
    /**
     * Test loadTrack
     */
    public function testLoadTrack()
    {
        $heap = [20000, 19000, 11000, 1000, 900, 600, 200, 34, 1];

        $refl = new \ReflectionClass(RockTransporterCommand::class);
        $method = $refl->getMethod('loadTrack');
        $method->setAccessible(true);

        $command = new RockTransporterCommand();

        $args = [&$heap];
        $round1 = $method->invokeArgs($command, $args);
        $this->assertEquals([20000, 1000, 900, 600, 200, 34, 1], $round1);

        $round2 = $method->invokeArgs($command, $args);
        $this->assertEquals([19000, 11000], $round2);

        $this->assertEmpty($heap);
    }
}
