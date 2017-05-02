<?php

namespace AppBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use AppBundle\Service\LoanCalculator;

/**
 * LoanCalculatorTest
 *
 * @author aliaksei
 */
class LoanCalculatorTest  extends TestCase
{
    /**
     * Test getMonthPayment()
     */
    public function testGetMonthPayment()
    {
        $calc = new LoanCalculator();
        $calc->setAmount(100000)
            ->setPeriod(6)
            ->setRate(0.1);

        $this->assertEquals(17156.14, $calc->getMonthPayment());
    }

    /**
     * Test calculate()
     */
    public function testCalculate()
    {
        $calc = new LoanCalculator();
        $calc->setAmount(100000)
            ->setPeriod(6)
            ->setRate(0.1)
            ->setFirstPayment(new \DateTime('2017-05-31'));

        $expected = [
            ['date' => new \DateTime('2017-05-31'), 'mainDebt' => 16322.81, 'interest' => 833.33, 'payment' => 17156.14, 'debt' => 83677.19],
            ['date' => new \DateTime('2017-06-30'), 'mainDebt' => 16458.83, 'interest' => 697.31, 'payment' => 17156.14, 'debt' => 67218.36],
            ['date' => new \DateTime('2017-07-31'), 'mainDebt' => 16595.99, 'interest' => 560.15, 'payment' => 17156.14, 'debt' => 50622.38],
            ['date' => new \DateTime('2017-08-31'), 'mainDebt' => 16734.29, 'interest' => 421.85, 'payment' => 17156.14, 'debt' => 33888.09],
            ['date' => new \DateTime('2017-09-30'), 'mainDebt' => 16873.74, 'interest' => 282.40, 'payment' => 17156.14, 'debt' => 17014.35],
            ['date' => new \DateTime('2017-10-31'), 'mainDebt' => 17014.35, 'interest' => 141.79, 'payment' => 17156.14, 'debt' => 0],
        ];

        $result = $calc->calculate();
        $this->assertEquals($expected, $result);
    }

    /**
     * Test getOverpayments()
     */
    public function testGetOverpayments()
    {
        $calc = new LoanCalculator();
        $calc->setAmount(100000)
            ->setPeriod(6)
            ->setRate(0.1);

        $this->assertEquals(2936.84, $calc->getOverpayments());
    }

    /**
     * Test nextMonth()
     */
    public function testNextMonth()
    {
        $refl = new \ReflectionClass(LoanCalculator::class);
        $method = $refl->getMethod('nextMonth');
        $method->setAccessible(true);

        $r1 = $method->invoke(new LoanCalculator(), new \DateTime('2017-05-31'));
        $this->assertEquals(new \DateTime('2017-06-30'), $r1);

        $r2 = $method->invoke(new LoanCalculator(), new \DateTime('2017-06-30'));
        $this->assertEquals(new \DateTime('2017-07-31'), $r2);
    }
}
