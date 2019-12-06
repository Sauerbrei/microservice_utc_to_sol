<?php
declare(strict_types=1);

namespace Billie\MarsTimeService\Interfaces;

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface ControllerProcessorInterface
 *
 * @package Billie\MarsTimeService\Interfaces
 */
interface ControllerProcessorInterface
{

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function process(Request $request);
}
