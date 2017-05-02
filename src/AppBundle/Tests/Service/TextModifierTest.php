<?php

namespace AppBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use AppBundle\Service\TextModifier;

/**
 * TextModifierTest
 *
 * @author aliaksei
 */
class TextModifierTest extends TestCase
{
    public function testExchange()
    {
        $refl = new \ReflectionClass(TextModifier::class);
        $method = $refl->getMethod('exchange');
        $method->setAccessible(true);

        $this->assertEquals('Три', $method->invoke(new TextModifier(), 'Лорем', 'три'));
        $this->assertEquals('три', $method->invoke(new TextModifier(), 'доминг', 'три'));
    }

    /**
     * Test modify()
     */
    public function testModify()
    {
        $chunk = "Лорем ипсум долор сит амет, симул доминг цонцептам яуи ат, ех деленит оффендит еум, еу мел цлита еуисмод.";
        $expected = "Лорем ипсум три сит пять, три доминг цонцептам три пять, ех три оффендит еум, пятнадцать мел цлита три.";

        $textModifier = new TextModifier();
        $offset = 0;
        $this->assertEquals($expected, $textModifier->modify($chunk, $offset));
        $this->assertEquals(18, $offset);
    }

    /**
     * Test run()
     */
    public function testRun()
    {
        $mock = $this->getMockBuilder(TextModifier::class)
            ->setMethods(['readFile'])->getMock();
        $mock->method('readFile')->willReturn([
            "Лорем ипсум долор сит амет, симул доминг цонцептам яуи ат, ех деленит\n",
            "оффендит еум, еу мел цлита еуисмод.\n"
        ]);

        $expected = <<<EOL
Лорем ипсум три сит пять, три доминг цонцептам три пять, ех три
оффендит еум, пятнадцать мел цлита три.

EOL;
        $refl = new \ReflectionObject($mock);
        $method = $refl->getMethod('run');
        $method->invoke($mock, 'any_in', '/tmp/out.txt');

        $this->assertEquals($expected, file_get_contents('/tmp/out.txt'));
    }
}
