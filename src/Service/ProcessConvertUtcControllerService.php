<?php
declare(strict_types=1);

namespace Billie\MarsTimeService\Service;

use Billie\MarsTimeService\Exception\FormatException;
use Billie\MarsTimeService\Interfaces\ControllerProcessorInterface;
use Billie\MarsTimeService\Model\MarsTime;
use Billie\MarsTimeService\Service\MarsTimeService;
use Billie\MarsTimeService\Validator\UtcTimeValidator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class ProcessConvertUtcControllerService
 *
 * @package Billie\MarsTimeService\Service
 */
class ProcessConvertUtcControllerService implements ControllerProcessorInterface
{
    /**
     * @var UtcTimeValidator
     */
    private $utcTimeValidator;

    /**
     * @var MarsTimeService
     */
    private $marsTimeService;

    /**
     * ProcessConvertUtcControllerService constructor.
     *
     * @param UtcTimeValidator $utcTimeValidator
     * @param MarsTimeService    $marsTimeService
     */
    public function __construct(UtcTimeValidator $utcTimeValidator, MarsTimeService $marsTimeService)
    {
        $this->utcTimeValidator = $utcTimeValidator;
        $this->marsTimeService = $marsTimeService;
    }

    /**
     * @param Request $request
     *
     * @return MarsTime
     * @throws BadRequestHttpException
     * @throws FormatException
     */
    public function process(Request $request): MarsTime
    {
        $data = json_decode($request->getContent(), true);
        $utc = $data['utc'] ?? '';

        if (strlen($utc) === 0) {
            throw new BadRequestHttpException('field:utc:missing');
        }

        $this->utcTimeValidator->check($utc);

        return $this->marsTimeService->fromUtc($utc);
    }
}
