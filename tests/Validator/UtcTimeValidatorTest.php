<?php
declare(strict_types=1);

namespace Billie\MarsTimeService\Tests\Validator;

use Billie\MarsTimeService\Exception\FormatException;
use Billie\MarsTimeService\Service\MarsTimeService;
use Billie\MarsTimeService\Validator\UtcTimeValidator;
use PHPUnit\Framework\TestCase;

/**
 * Class UtcTimeValidatorTest
 *
 * @package Billie\MarsTimeService\Tests\Validator
 */
class UtcTimeValidatorTest extends TestCase
{
    /**
     * @var UtcTimeValidator
     */
    private $validator;

    /**
     *
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->validator = new UtcTimeValidator;
    }

    /**
     */
    public function testValidUtcTime(): void
    {
        $dateTime = new \DateTime;
        $format   = $dateTime->format(MarsTimeService::DEFAULT_UTC_FORMAT);
        $check    = $this->validator->check($format);

        $this->assertTrue($check, 'Validator should pass');
    }

    /**
     *
     */
    public function testInvalidUtcTime(): void
    {
        $this->expectException(FormatException::class);
        $dateTime = new \DateTime;
        $format   = $dateTime->format(\DateTime::RFC822);
        $this->validator->check($format);
    }

    /**
     *
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        $this->validator = null;
    }
}
