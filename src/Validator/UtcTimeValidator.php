<?php
declare(strict_types=1);

namespace Billie\MarsTimeService\Validator;

use Billie\MarsTimeService\Exception\FormatException;
use Billie\MarsTimeService\Service\MarsTimeService;

/**
 * Class UtcTimeValidator
 *
 * @package Billie\MarsTimeService\Validator
 */
class UtcTimeValidator
{

    /**
     * @param string $date
     *
     * @return bool
     * @throws FormatException
     */
    public function check(string $date): bool
    {
        $date = \DateTime::createFromFormat(MarsTimeService::DEFAULT_UTC_FORMAT, $date);

        if ($date === false) {
            throw new FormatException;
        }

        return true;
    }
}
