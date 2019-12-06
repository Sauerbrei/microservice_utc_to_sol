<?php
declare(strict_types=1);

namespace Billie\MarsTimeService\Service;

use Billie\MarsTimeService\Model\MarsTime;

/**
 * Class MarsTimeService
 *
 * @package Billie\MarsTimeService\Service
 */
class MarsTimeService
{
    public const DEFAULT_UTC_FORMAT = \DateTime::ISO8601;
    private const SECONDS_PER_DAY = 86400;
    private const JULIAN_DATE_AT_UNIX_BEGINNING = 2440587.5;
    private const JULIAN_DATE_AT_DEC_29_1873 = 2405522.0025054;
    private const ONE_SOL_FACTOR = 1.0274912517;

    // it is not predictable when a leap second has to be added
    // there could be another microservice who provides this number
    // for instance we could parse https://www.ietf.org/timezones/data/leap-seconds.list
    // or handle this with ntp https://access.redhat.com/articles/15145
    // as for this coding challenge, this has to be enough :-)
    private const TEMPORARY_WORKAROUND_LEAP_SECONDS = 37;

    /**
     * @param string $utc
     *
     * @return MarsTime
     */
    public function fromUtc(string $utc): MarsTime
    {
        $date = \DateTime::createFromFormat(self::DEFAULT_UTC_FORMAT, $utc);
        $julianDateUtc = $this->calculateJulianDateFromUtc($date);
        $msd = $this->calculateMsdFromJulianDateUtc(
            $julianDateUtc,
            self::TEMPORARY_WORKAROUND_LEAP_SECONDS
        );
        $mtc = $this->msdToMtc($msd);

        return (new MarsTime)->setMsd($msd)->setMtc($mtc);
    }

    /**
     * @param float $msd
     *
     * @return string
     */
    public function msdToMtc(float $msd): string
    {
        $timestamp = (int)ceil(fmod($msd, 1) * self::SECONDS_PER_DAY) - 3600;
        $date = (new \DateTime)->setTimestamp($timestamp);
        return $date->format('H:i:s');
    }

    /**
     * @param \DateTime $dateTime
     *
     * @return float
     */
    private function calculateJulianDateFromUtc(\DateTime $dateTime): float
    {
        return $dateTime->getTimestamp() / self::SECONDS_PER_DAY + self::JULIAN_DATE_AT_UNIX_BEGINNING;
    }

    /**
     * @param float $julianDateUtc
     * @param int   $taiUtc
     *
     * @return float
     */
    private function calculateMsdFromJulianDateUtc(float $julianDateUtc, int $taiUtc): float
    {
        return ($julianDateUtc + $taiUtc / self::SECONDS_PER_DAY - self::JULIAN_DATE_AT_DEC_29_1873)
            / self::ONE_SOL_FACTOR;
    }
}
