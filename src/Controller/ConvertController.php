<?php
declare(strict_types=1);

namespace Billie\MarsTimeService\Controller;

use Billie\MarsTimeService\Exception\FormatException;
use Billie\MarsTimeService\Service\ProcessConvertUtcControllerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ConvertController
 *
 * @package Billie\MarsTimeService\Controller
 * @Route("/convert", name="convert_")
 */
class ConvertController extends AbstractController
{
    /**
     * @Route("/utc", name="utc", methods={"POST"})
     * @return JsonResponse
     */
    public function convertUtcToMarsianTimeAction(
        Request $request,
        ProcessConvertUtcControllerService $service
    ): JsonResponse {
        try {
            $response = $service->process($request);
        } catch (FormatException $exception) {
            return $this->json(
                ['success' => false, 'message' => 'error:format'],
                Response::HTTP_BAD_REQUEST
            );
        } catch (BadRequestHttpException $exception) {
            return $this->json(
                ['success' => false, 'message' => $exception->getMessage()],
                Response::HTTP_BAD_REQUEST
            );
        } catch (\Exception $exception) {
            //@ToDo log exception
            var_dump($exception->getMessage());
            var_dump($exception->getTrace());
            return $this->json(
                ['success' => false, 'message' => 'internal:server:error'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $this->json((['success' => true] + $response->toArray()));
    }
}
