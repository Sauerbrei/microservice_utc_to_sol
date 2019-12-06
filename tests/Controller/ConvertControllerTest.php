<?php
declare(strict_types=1);

namespace Billie\MarsTimeService\Tests\Controller;

use Billie\MarsTimeService\Service\MarsTimeService;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class ConvertControllerTest
 *
 * @package Billie\MarsTimeService\Tests\Controller
 */
class ConvertControllerTest extends WebTestCase
{
    /**
     * @var KernelBrowser
     */
    private $client;

    /**
     *
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    /**
     *
     */
    public function testConvertUtcSuccessfully(): void
    {
        // 2019-12-06 16:16:05 UTC
        $date = (new \DateTime)->setTimestamp(1575648965);
        $utc = $date->format(MarsTimeService::DEFAULT_UTC_FORMAT);
        $data = $this->callEndpoint($utc);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        // close enough!
        // values taken from https://en.wikipedia.org/wiki/Timekeeping_on_Mars
        $this->assertEquals(51876.03853, round($data['msd'], 5), 'MSD should be valid');
        $this->assertEquals('00:55:29', $data['mtc'], 'MTC should be valid');
    }

    /**
     *
     */
    public function testConvertUtcSuccessfully2(): void
    {
        // 2000-01-01 00:00:00 UTC
        $date = (new \DateTime)->setTimestamp(946684800);
        $utc = $date->format(MarsTimeService::DEFAULT_UTC_FORMAT);
        $data = $this->callEndpoint($utc);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        // values taken from https://jtauber.github.io/mars-clock/
        $this->assertEquals(44791.13360, round($data['msd'], 5), 'MSD should be valid');
        $this->assertEquals('03:12:23', $data['mtc'], 'MTC should be valid');
    }

    /**
     *
     */
    public function testConvertUtcFalseFormat(): void
    {
        // 2000-01-01 00:00:00 UTC
        $date = (new \DateTime)->setTimestamp(946684800);
        $utc = $date->format(\DateTime::COOKIE);
        $this->callEndpoint($utc);

        $this->assertEquals(400, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @param string $utc
     *
     * @return array
     */
    private function callEndpoint(string $utc): array
    {

        $this->client->request(
            'POST',
            '/api/convert/utc',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            sprintf('{"utc": "%s"}', $utc)
        );
        $content = $this->client->getResponse()->getContent();
        return json_decode($content, true);
    }
}
