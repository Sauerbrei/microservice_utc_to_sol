<?php
declare(strict_types=1);

namespace Billie\MarsTimeService\Model;

use Billie\MarsTimeService\Interfaces\ToArrayInterface;

/**
 * Class MarsTime
 *
 * @package Billie\MarsTimeService\Model
 */
class MarsTime implements ToArrayInterface
{
    /**
     * @var float
     */
    private $msd = 0.0;

    /**
     * @var string
     */
    private $mtc = '';

    /**
     * @return float
     */
    public function getMsd(): float
    {
        return $this->msd;
    }

    /**
     * @param float $msd
     *
     * @return MarsTime
     */
    public function setMsd(float $msd): MarsTime
    {
        $this->msd = $msd;

        return $this;
    }

    /**
     * @return string
     */
    public function getMtc(): string
    {
        return $this->mtc;
    }

    /**
     * @param string $mtc
     *
     * @return MarsTime
     */
    public function setMtc(string $mtc): MarsTime
    {
        $this->mtc = $mtc;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'mtc' => $this->mtc,
            'msd' => $this->msd,
        ];
    }
}
