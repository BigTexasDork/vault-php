<?php

use Psr\Log\NullLogger;
use Vault\AuthenticationStrategies\TokenAuthenticationStrategy;
use Vault\Client;
use VaultTransports\Guzzle6Transport;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class TokenAuthenticationStrategyTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testCanAuthenticate()
    {
        $log = new Logger('name');
        $log->pushHandler(new StreamHandler('./log.log', Logger::DEBUG));

        $client = (new Client(new Guzzle6Transport(['base_uri' => 'http://10.0.62.176:8200'])))
            ->setAuthenticationStrategy(new TokenAuthenticationStrategy('s.5ajAImFmAnCpqBdm9qpaNFTk'))
            ->setLogger($log);

        $this->assertEquals($client->getAuthenticationStrategy()->getClient(), $client);
        $this->assertTrue($client->authenticate());
        $this->assertNotEmpty($client->getToken());

        return $client;
    }

    protected function setUp()
    {
        \VCR\VCR::turnOn();

        \VCR\VCR::insertCassette('authentication-strategies/token');

        return parent::setUp();
    }

    protected function tearDown()
    {
        // To stop recording requests, eject the cassette
        \VCR\VCR::eject();

        // Turn off VCR to stop intercepting requests
        \VCR\VCR::turnOff();

        parent::tearDown();
    }

    protected function _before()
    {
    }

    protected function _after()
    {
    }
}
