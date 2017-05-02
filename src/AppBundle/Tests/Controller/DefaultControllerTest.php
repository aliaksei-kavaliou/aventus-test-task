<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * DefaultControllerTest
 *
 * @author aliaksei
 */
class DefaultControllerTest extends WebTestCase
{
    /**
     * Test indexAction
     */
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isOk());
        $this->assertContains('Menu', $crawler->filter('title')->text());
        $this->assertCount(2, $crawler->filter('a'));
    }

    /**
     * Test chessBoardAction()
     */
    public function testChessBoardAction()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/chess/board');

        $board = $crawler->filterXPath('//table[@class="board"]');
        $this->assertNotEmpty($board);
        $this->assertCount(80, $board->filterXPath('//tbody')->filter('td'));
        $this->assertCount(32, $board->filterXPath('//tbody')->filter('td.white'));
        $this->assertEquals(8, $board->filterXPath('//tbody')->filter('td')->getNode(0)->nodeValue);
        $this->assertEquals(1, $board->filterXPath('//tbody')->filter('td')->getNode(70)->nodeValue);
        $this->assertContains('white', $board->filter('tbody > tr > td.cell')->first()->attr('class'));
        $this->assertContains('black', $board->filter('tbody > tr > td.cell')->getNode(1)->getAttribute('class'));
        $this->assertContains('white', $board->filter('tbody > tr > td.cell')->last()->attr('class'));
        $this->assertEquals('a', $board->filterXpath('//thead')->filter('td')->getNode(1)->nodeValue);
        $this->assertEquals('h', $board->filterXpath('//tfoot')->filter('td')->getNode(8)->nodeValue);
    }

    /**
     * Test loanAction()
     */
    public function testLoanAction()
    {
        $client = self::createClient();
        $token = $client->getContainer()->get('security.csrf.token_manager')->getToken('loan_calculator');
        $crawler = $client->request('GET', '/loan');

        $this->assertTrue($client->getResponse()->isOk());
        $form = $crawler->filterXPath('//form[@name="loan"]');
        $this->assertNotEmpty($form);
        $this->assertNotEmpty($form->filterXPath('//input[@id="loan_amount"]'));
        $this->assertNotEmpty($form->filterXPath('//input[@id="loan_period"]'));
        $this->assertNotEmpty($form->filterXPath('//input[@id="loan_rate"]'));
        $this->assertNotEmpty($form->filterXPath('//input[@id="loan_firstPayment"]'));
        $this->assertNotEmpty($form->filterXPath('//input[@type="submit"]'));

        $crawler1 = $client->request('POST', '/loan', [
            'loan' => [
                'amount' => 100000,
                'period' => 6,
                'rate' => 10,
                'firstPayment' => '2017-05-31',
                '_token' => $token,
            ],
        ]);

        $this->assertTrue($client->getResponse()->isOk());
        $table = $crawler1->filterXPath('//table[@id="payments"]');
        $this->assertNotEmpty($table);
        $this->assertCount(6, $table->filterXPath('//tbody')->filter('tr'));
    }
}
